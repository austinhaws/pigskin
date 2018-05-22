<?php

namespace App\WebAPI\Services\Draft;

use App\WebAPI\Enums\DraftState;
use App\WebAPI\Enums\Position;
use App\WebAPI\Enums\TeamType;
use App\WebAPI\Models\Draft;
use App\WebAPI\Models\DraftSequence;
use App\WebAPI\Models\Player;
use App\WebAPI\Models\Team;
use App\WebAPI\Services\BaseDaoService;

class DraftCreateService extends BaseDaoService
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
			$draftSequence = new DraftSequence();
			$draftSequence->teamGuid = $teamGuid;
			return $draftSequence;
		}, array_merge($teamGuids, $teamGuids, $teamGuids, $teamGuids, $teamGuids));

		// insert draft object
		$draft->id = $this->daos->draft->insertDraft($this->webApi->draftTranslator->toDBArray($draft));

		// link cpuTeams to draft teams
		foreach ($cpuTeams as $cpuTeam) {
			$this->daos->draft->insertDraftXTeam($draft->id, $cpuTeam->id);
		}
		$this->daos->draft->insertDraftXTeam($draft->id, $playerTeam->id);

		// start picking CPU players' picks until hit a non-CPU player
		$this->webApi->draftCPUPickService->cpuPickPlayers($draft);

		// save now that some picks may have been made by CPUs
		$this->daos->draft->updateDraft($this->webApi->draftTranslator->toDBArray($draft));

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
