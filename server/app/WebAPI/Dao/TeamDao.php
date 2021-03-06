<?php

namespace App\WebAPI\Dao;

use App\WebAPI\Enums\DBTable;
use Illuminate\Support\Facades\DB;

class TeamDao extends BaseDao
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
		if (!$team['id'] && !$team['guid']) {
			var_dump($team);
			throw new \RuntimeException('Team has no identifier');
		}

		$sql = DB::table(DBTable::TEAM);

		if ($team['id']) {
			$sql = $sql->where('id', $team['id']);
		}
		if ($team['guid']) {
			$sql = $sql->where('guid', $team['guid']);
		}

		$sql->update($this->removeFields($team));
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

	/**
	 * @param int $accountId
	 * @return \Illuminate\Support\Collection
	 */
	public function selectTeamsForAccountId(int $accountId) {
		return DB::table(DBTable::TEAM)->where('accountId', $accountId)->get();
	}
}
