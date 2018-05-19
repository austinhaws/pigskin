<?php

namespace App\WebAPI\Dao;

use App\WebAPI\Enums\DBTable;
use Illuminate\Support\Facades\DB;

class TeamDao
{
	/**
	 * @param array $team the team to insert
	 *
	 * @return int
	 */
	public function insertTeam(array $team) {
		return DB::table(DBTABLE::TEAM)->insertGetId($team);
	}

	/**
	 * @param array $team
	 */
	public function updateTeam(array $team)
	{
		DB::table(DBTable::TEAM)->update($team);
	}

	/**
	 * @param string|null $accountGuid
	 * @param string|null $teamGuid
	 * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object
	 */
	public function selectTeam(string $accountGuid = null, string $teamGuid = null)
	{
		$query = DB::table(DBTable::TEAM)->select('team.*');
		if ($accountGuid) {
			$query = $query->join(DBTable::ACCOUNT, 'account.id', '=', 'team.accountId');
			$query = $query->where('account.guid', $accountGuid);
		}
		if ($teamGuid) {
			$query = $query->where('team.guid', $teamGuid);
		}
		return $query->first();
	}
}
