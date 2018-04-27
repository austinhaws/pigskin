<?php

namespace App\WebAPI\Services;

use Illuminate\Support\Facades\DB;

class TeamService extends BaseService
{
	/**
	 * get an account
	 *
	 * @param $accountId int account that owns the team (for now one team per account)
	 * @return object the found team or null
	 */
	public function get($accountId)
	{
		return DB::table('team')->where('account_id', $accountId)->first();
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

		DB::table('team')->insert([
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

		for ($i = 0; $i < 11; $i++) {
			$this->boostPlayer($players[$this->webApi->rollService->roll(0, count($players) - 1)]);
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
			$this->webApi->playerService->createPlayer($position, Rating::F);
		}, $positions);
	}
}
