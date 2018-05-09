<?php

namespace App\WebAPI\Services;

use App\WebAPI\Enums\DBTable;
use App\WebAPI\Enums\Rating;
use App\WebAPI\Enums\Roster;
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

		DB::table(DBTable::TEAM)->insert([
			'account_id' => $accountId,
			'name' => $name,
			'players' => json_encode($players),
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
			$this->fillRoster(Roster::SPECIAL_MINIMUM)
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
	 * @return array of players created
	 */
	private function fillRoster($positions) {
		return array_map(function ($position) {
			return $this->webApi->playerService->createPlayer($position, Rating::F);
		}, $positions);
	}
}
