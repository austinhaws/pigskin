<?php

namespace App\WebAPI\Services;

use App\WebAPI\Enums\PositionType;
use App\WebAPI\Enums\Rating;
use App\WebAPI\Enums\Roster;
use App\WebAPI\Enums\TeamStage;
use App\WebAPI\Enums\TeamType;
use App\WebAPI\Models\Lineup;
use App\WebAPI\Models\Player;
use App\WebAPI\Models\Team;

class TeamService extends BaseService
{
	const NUMBER_STARTING_BOOSTS = 10;

	/**
	 * get an account
	 *
	 * @param $accountGuid string account that owns the team (for now one team per account)
	 * @param null $teamGuid string if present, gets that team id
	 * @return Team the found team or null
	 */
	public function get($accountGuid, $teamGuid = null)
	{
		return $this->webApi->teamTranslator->fromDBObj($this->webApi->teamDao->selectTeam($accountGuid, $teamGuid));
	}

	/**
	 * create a new account
	 *
	 * @param $accountId int account that owns the team (for now one team per account)
	 * @param $teamType string TeamType... enum is this team a CPU controlled team (no account)
	 * @return Team the created team
	 */
	public function create($accountId, $teamType)
	{
		if ($accountId && $teamType === TeamType::CPU) {
			throw new \RuntimeException('CPU teams can not have an account');
		} else if (!$accountId && $teamType === TeamType::PLAYER) {
			throw new \RuntimeException('Non-CPU teams must have an account');
		}
		$team = new Team();
		$team->accountId = $accountId;
		$team->name = $this->webApi->phraseService->getRandomPhrase();
		$team->players = $this->createPlayers();
		$team->lineups = $this->createLineups($team->players);
		$team->guid = $this->webApi->guidService->getNewGUID();
		$team->stage = TeamStage::DRAFT;
		$team->teamType = $teamType;

		$team->id = $this->webApi->teamDao->insertTeam($this->webApi->teamTranslator->toDBArray($team));

		$accountGuid = null;
		if ($accountId) {
			$account = $this->webApi->accountService->get($accountId);
			$accountGuid = $account->guid;
		}
		return $this->get($accountGuid, $team->guid);
	}

	/**
	 * create the players for a new team
	 *
	 * @return Player[]
	 */
	private function createPlayers()
	{
		$players = array_merge(
			$this->fillRoster(Roster::OFFENSE_MINIMUM),
			$this->fillRoster(Roster::DEFENSE_MINIMUM),
			$this->fillRoster(Roster::KICK_MINIMUM)
		);

		for ($i = 0; $i < TeamService::NUMBER_STARTING_BOOSTS; $i++) {
			$this->webApi->playerService->boostPlayer($players[$this->webApi->rollService->roll(0, count($players) - 1)]);
		}

		return $players;
	}

	/**
	 * create a player for each given position type
	 *
	 * @param $positions array of string of positions to fill
	 * @return Player[] players created
	 */
	private function fillRoster($positions) {
		return array_map(function ($position) {
			return $this->webApi->playerService->createPlayer($position, Rating::F);
		}, $positions);
	}

	/***
	 * define a defense, offense, and special teams lineups as a default for the team
	 *
	 * @param $players array of Player of the players on the team
	 * @return Lineup[]
	 */
	private function createLineups($players)
	{
		return [
			$this->createLineup($players, PositionType::OFFENSE),
			$this->createLineup($players, PositionType::DEFENSE),
			$this->createLineup($players, PositionType::KICK),
		];
	}

	/**
	 * fill a lineup with players from the team
	 *
	 * @param $players array of Player on team
	 * @param $positionType string PositionType::... what type of lineup to create
	 * @return Lineup
	 */
	private function createLineup($players, $positionType) {
		$lineup = new LineUp();
		$lineup->name = $positionType;
		$lineup->positionType = $positionType;
		$roster = Roster::rosterForPositionType($positionType);

		shuffle($players);

		// assumes that the minimum roster slots all have at least one position
		foreach ($players as $player) {
			$pos = array_search($player->position, $roster);
			if ($pos !== false) {
				$lineup->playerGuids[] = $player->guid;
				unset($roster[$pos]);
			}
		}

		return $lineup;
	}
}
