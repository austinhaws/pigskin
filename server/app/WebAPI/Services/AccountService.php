<?php

namespace App\WebAPI\Services;

use App\WebAPI\Enums\DBTable;
use App\WebAPI\Enums\TeamType;
use Illuminate\Support\Facades\DB;

class AccountService extends BaseService
{
	/**
	 * get an account
	 *
	 * @param $phraseOrGuid string could be a phrase or a guid
	 * @return object the found account or null
	 */
	public function get($phraseOrGuid)
	{
		$account = DB::table(DBTable::ACCOUNT)->where('phrase', $phraseOrGuid)->first();
		if (!$account) {
			$account = DB::table(DBTable::ACCOUNT)->where('guid', $phraseOrGuid)->first();
		}
		if ($account) {
			$account->team = $this->webApi->responseService->cleanRecord($this->webApi->teamService->get($account->id), ['account_id']);
		}
		return $account;
	}

	/**
	 * create a new account
	 *
	 * @return object the created account
	 */
	public function create()
	{
		$phrase = $this->webApi->phraseService->getNewPhrase();
		$guid = $this->webApi->guidService->getNewGuid();
		$accountId = DB::table(DBTable::ACCOUNT)->insertGetId(['phrase' => $phrase, 'guid' => $guid]);

		// also create a new team for the account
		$this->webApi->teamService->create($accountId, TeamType::PLAYER);

		return $this->get($phrase);
	}
}
