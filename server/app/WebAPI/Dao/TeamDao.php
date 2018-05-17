<?php

namespace App\WebAPI\Dao;

use App\WebAPI\Enums\DBTable;
use App\WebAPI\Models\Team;
use Illuminate\Support\Facades\DB;

class TeamDao
{
	/**
	 * @param $team Team the team to insert
	 */
	public function insertTeam(&$team) {
		$team->id = DB::table(DBTABLE::TEAM)->insertGetId([
			'account_id' => $team->accountId,
			'guid' => $team->guid,
			'name' => $team->name,
			'players' => json_encode($team->players),
			'lineups' => json_encode($team->lineups),
			'team_type' => $team->teamType,
			'stage' => $team->stage,
		]);
	}
}
