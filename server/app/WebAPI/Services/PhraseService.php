<?php

namespace App\WebAPI\Services;

class PhraseService extends BaseDaoService
{
	/**
	 * randomly select a phrase
	 *
	 * @return string
	 */
	public function getRandomPhrase() {
		return $this->daos->accountWord->selectRandomPhrase();
	}

	/**
	 * get a new phrase that has not been used on any account yet
	 * @return string
	 */
	public function getNewPhrase()
	{
		do {
			$phrase = $this->getRandomPhrase();
			$account = $this->daos->account->select(null, null, $phrase);
		} while ($account);
		return $phrase;
	}
}