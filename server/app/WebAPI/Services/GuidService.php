<?php

namespace App\WebAPI\Services;

class GuidService extends BaseDaoService
{
	/**
	 * get a new guid that has not been used on any account yet
	 * @return string
	 */
	public function getNewGUID()
	{
		do {
			$guid = uniqid();
			$account = $this->daos->account->select(null, $guid, null);
		} while ($account);
		return $guid;
	}

	/**
	 * @param $guid string the guid to check
	 * @return bool true if the guid is a guid
	 */
	public function isGuid($guid)
	{
		return
			1 === preg_match('/^[a-z|0-9]{13}$/i', $guid) &&
			1 !== preg_match('/^[A-Z][a-z]+[A-Z][a-z]+\d\d$/', $guid);
	}
}