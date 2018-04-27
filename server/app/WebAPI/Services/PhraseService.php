<?php

namespace App\WebAPI\Services;

use Illuminate\Support\Facades\DB;

class PhraseService extends BaseService
{
	/**
	 * randomly select a phrase
	 *
	 * @return string
	 */
	public function getRandomPhrase() {
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
					FLOOR(RAND() * 100) + 10
				) AS phrase
		"))->phrase;
	}

	/**
	 * get a new phrase that has not been used on any account yet
	 * @return string
	 */
	public function getNewPhrase()
	{
		do {
			$phrase = $this->getRandomPhrase();
			$account = DB::table('account')->where('phrase', $phrase)->get();
		} while (count($account));
		return $phrase;
	}
}