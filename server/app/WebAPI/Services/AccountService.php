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
	 * @param $phraseOrGuidOrId string|int could be a phrase or a guid
	 * @return object the found account or null
	 */
	public function get($phraseOrGuidOrId)
	{
		$account = DB::table(DBTable::ACCOUNT)->where('phrase', $phraseOrGuidOrId)->first();
		if (!$account) {
			$account = DB::table(DBTable::ACCOUNT)->where('guid', $phraseOrGuidOrId)->first();
		}
		if (!$account) {
			$account = DB::table(DBTable::ACCOUNT)->where('id', $phraseOrGuidOrId)->first();
		}
		if ($account) {
			$account->team = $this->webApi->responseService->cleanRecord($this->webApi->teamService->get($account->guid), ['accountId']);
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
