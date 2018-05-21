<?php

namespace App\WebAPI\Services;

class NameService extends BaseDaoService
{
	/**
	 * randomly select a phrase
	 *
	 * @return string
	 */
	public function getRandomName() {
		return $this->daos->name->selectRandomName();
	}
}
