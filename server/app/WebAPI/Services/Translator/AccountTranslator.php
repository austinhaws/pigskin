<?php

namespace App\WebAPI\Services\Translator;

use App\WebAPI\Models\Account;

class AccountTranslator extends BaseTranslator
{
	/**
	 * @param Account $account
	 * @return array representing the DB Object
	 */
	public function toDBArray($account)
	{
		return [
			'id' => $account->id,
			'phrase' => $account->phrase,
			'guid' => $account->guid,
		];
	}

	/**
	 * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object $accountDB
	 * @return Account
	 */
	public function fromDBObj($accountDB)
	{
		if ($accountDB) {
			$account = new Account();
			$account->id = $accountDB->id;
			$account->guid = $accountDB->guid;
			$account->phrase = $accountDB->phrase;
		} else {
			$account = null;
		}

		return $account;
	}
}
