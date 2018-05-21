<?php

namespace App\WebAPI\Services;

use App\WebAPI\Enums\TeamType;
use App\WebAPI\Models\Account;

class AccountService extends BaseDaoService
{
	/**
	 * get an account
	 *
	 * @param $phraseOrGuidOrId string|int could be a phrase or a guid
	 * @return object the found account or null
	 */
	public function get($phraseOrGuidOrId)
	{
		$phrase = null;
		$guid = null;
		$id = null;
		if ($this->webApi->guidService->isGuid($phraseOrGuidOrId)) {
			$guid = $phraseOrGuidOrId;
		} else if (is_int($phraseOrGuidOrId)) {
			$id = intval($phraseOrGuidOrId);
		} else {
			$phrase = $phraseOrGuidOrId;
		}

		$account = $this->daos->account->select($id, $guid, $phrase);


		if ($account) {
			$account->team = $this->webApi->responseService->cleanRecord($this->webApi->teamService->get($account->guid), ['accountId']);
		}

		return $account;
	}

	/**
	 * create a new account
	 *
	 * @return Account the created account
	 */
	public function create()
	{
		$account = new Account();
		$account->phrase = $this->webApi->phraseService->getNewPhrase();
		$account->guid = $this->webApi->guidService->getNewGuid();
		$this->daos->account->insert($account);

		// also create a new team for the account
		$account->team = $this->webApi->teamService->create($account->id, TeamType::PLAYER);

		return $account;
	}
}
