<?php

use Illuminate\Support\Facades\DB;

require_once 'BaseService.php';

class PhraseService extends BaseService
{
	/**
	 * randomly select a phrase
	 *
	 * @return string
	 */
	private function selectRandomWord() {
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
			$phrase = $this->selectRandomWord();
			$account = DB::table('account')->where('phrase', $phrase)->get();
		} while (count($account));
		return $phrase;
	}
}