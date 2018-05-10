<?php

namespace App\WebAPI\Services;

use App\WebAPI\Enums\DBTable;
use App\WebAPI\Enums\PositionType;
use App\WebAPI\Enums\Rating;
use App\WebAPI\Enums\Roster;
use App\WebAPI\Models\Lineup;
use App\WebAPI\Models\Player;
use Illuminate\Support\Facades\DB;

class TeamService extends BaseService
{
	const NUMBER_STARTING_BOOSTS = 10;

	/**
	 * get an account
	 *
	 * @param $accountId int account that owns the team (for now one team per account)
	 * @return object the found team or null
	 */
	public function get($accountId)
	{
		$team = DB::table(DBTable::TEAM)->where('account_id', $accountId)->first();
		$team->players = $this->webApi->jsonService->jsonToObjectArray($team->players, Player::class);
		$team->lineups = $this->webApi->jsonService->jsonToObjectArray($team->lineups, Lineup::class);
		return $team;
	}

	/**
	 * create a new account
	 *
	 * @param $accountId int account that owns the team (for now one team per account)
	 * @return object the created account
	 */
	public function create($accountId)
	{
		$name = $this->webApi->phraseService->getRandomPhrase();

		$players = $this->createPlayers();
		$lineups = $this->createLineups($players);

		DB::table(DBTable::TEAM)->insert([
			'account_id' => $accountId,
			'name' => $name,
			'players' => json_encode($players),
			'lineups' => json_encode($lineups)
		]);
		return $this->get($accountId);
	}

	/**
	 * create the players for a new team
	 *
	 * @return array of player objects
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
