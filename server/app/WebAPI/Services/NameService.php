<?php

namespace App\WebAPI\Services;

use Illuminate\Support\Facades\DB;

class NameService extends BaseService
{
	/**
	 * randomly select a phrase
	 *
	 * @return string
	 */
	public function getRandomName() {
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