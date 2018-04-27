<?php

namespace App\WebAPI\Services;

use App\WebAPI\Enums\DBTable;
use Illuminate\Support\Facades\DB;

class GuidService extends BaseService
{
	/**
	 * get a new guid that has not been used on any account yet
	 * @return string
	 */
	public function getNewGUID()
	{
		do {
			$guid = uniqid();
			$account = DB::table(DBTable::ACCOUNT)->where('guid', $guid)->get();
		} while (count($account));
		return $guid;
	}
}