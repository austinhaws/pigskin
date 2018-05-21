<?php

namespace App\WebAPI\Dao;

use Illuminate\Support\Facades\DB;

class AccountWordDao extends BaseDao
{
	public function selectRandomPhrase() {
		return DB::selectOne(DB::raw("
			SELECT
				CONCAT(
					(SELECT
						word
					FROM account_word
					WHERE type = 'adjective'
					ORDER BY rand()
					LIMIT 1),
					(SELECT
						word
					FROM account_word
					WHERE type = 'noun'
					ORDER BY rand()
					LIMIT 1),
					FLOOR(RAND() * 90) + 10
				) AS phrase
		"))->phrase;
	}
}
