<?php

namespace App\WebAPI\Dao;

use Illuminate\Support\Facades\DB;

class NameDao extends BaseDao
{
	public function selectRandomName() {
		return DB::selectOne(DB::raw("
			SELECT
				CONCAT_WS(
					' ',
					(
						SELECT word
						FROM account_word
						WHERE type = 'adjective'
						ORDER BY rand()
						LIMIT 1
					),
					(
						SELECT name
						FROM name
						ORDER BY rand()
						LIMIT 1
					)
				) AS name
		"))->name;
	}
}
