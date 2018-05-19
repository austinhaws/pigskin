<?php

namespace App\WebAPI\Services\Draft;

use App\WebAPI\Enums\DraftState;
use App\WebAPI\Enums\Position;
use App\WebAPI\Enums\TeamType;
use App\WebAPI\Models\Draft;
use App\WebAPI\Models\DraftSequence;
use App\WebAPI\Models\Player;
use App\WebAPI\Models\Team;
use App\WebAPI\Services\BaseService;

class DraftCreateService extends BaseService
{
	/** @var int how many CPUs to include in the draft with the real player */
	const NUMBER_CPUS = 5;
	/** @var int how many players to generate (6 teams * 5 picks + 15 unpicked bottom feeders) */
	const DRAFT_SIZE = 45;

	/**
	 * start a new draft with draft candidates and CPU players as needed
	 *
	 * @param $playerTeamGuid string id of the player team initiating this draft
	 * @return Draft the created and started draft
	 */
	public function createDraft($playerTeamGuid)
	{
		$draft = new Draft();
		$draft->state = DraftState::IN_PROGRESS;
		$draft->guid = $this->webApi->guidService->getNewGUID();

		// create a pool of available players
		$draft->availablePlayers = $this->createAvailablePlayers();

		// create CPU teams to fill drafting teams
		$cpuTeams = $this->createCPUs();

		// determine draft sequence
		$teamGuids = array_reduce($cpuTeams, function ($guids, $team) {
			$guids[] = $team->guid;
			return $guids;
		}, []);

		$playerTeam = $this->webApi->teamService->get(null, $playerTeamGuid);
		$teamGuids[] = $playerTeam->guid;

		shuffle($teamGuids);
		// cycle through 5 picks for each team
		$draft->draftSequence = array_map(function ($teamGuid) {
			return new DraftSequence($teamGuid, null);
		}, array_merge($teamGuids, $teamGuids, $teamGuids, $teamGuids, $teamGuids));

		// insert draft object
		$this->webApi->draftDao->insertDraft($draft);

		// link cpuTeams to draft teams
		foreach ($cpuTeams as $cpuTeam) {
			$this->webApi->draftDao->insertDraftXTeam($draft->id, $cpuTeam->id);
		}
		$this->webApi->draftDao->insertDraftXTeam($draft->id, $playerTeam->id);

		// start picking CPU players' picks until hit a non-CPU player
		$this->webApi->draftCPUPickService->cpuPickPlayers($draft);

		return $draft;
	}

	/**
	 * create cpu players
	 * @return Team[] CPU teams
	 */
	private function createCPUs()
	{
		$cpuTeams = [];
		for ($i = 0; $i < DraftCreateService::NUMBER_CPUS; $i++) {
			$cpuTeams[] = $this->webApi->teamService->create(null, TeamType::CPU);
		}
		return $cpuTeams;
	}

	/**
	 * @return Player[]
	 */
	private function createAvailablePlayers()
	{
		$players = [];
		$positions = Position::getConstants();
		while (count($players) < DraftCreateService::DRAFT_SIZE) {
			shuffle($positions);
			$rating = $this->webApi->chartService->rollUpgradeRating(1);
			$players[] = $this->webApi->playerService->createPlayer($positions[0], $rating);
		}

		return $players;
	}
}
