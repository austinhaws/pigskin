<?php

namespace App\WebAPI\Dao;

use App\WebAPI\Enums\DBTable;
use App\WebAPI\Models\Account;
use Illuminate\Support\Facades\DB;

class AccountDao extends BaseDao
{
	/**
	 * @param int $id
	 * @param string $guid
	 * @param string $phrase
	 * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|null|object
	 */
	public function select(int $id = null, string $guid = null, string $phrase = null) {
		$query = DB::table(DBTable::ACCOUNT);
		if ($id) {
			$query->where('id', $id);
		}
		if ($guid) {
			$query->where('guid', $guid);
		}
		if ($phrase) {
			$query->where('phrase', $phrase);
		}
		return $query->first();
	}

	/**
	 * @param Account $account
	 */
	public function insert(Account $account) {
		$account->id = DB::table(DBTable::ACCOUNT)->insertGetId(['phrase' => $account->phrase, 'guid' => $account->guid]);
	}
}