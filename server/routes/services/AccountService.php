<?php

use Illuminate\Support\Facades\DB;

require_once 'BaseService.php';

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
		$account = DB::table('account')->where('phrase', $phraseOrGuid)->first();
		if (!$account) {
			$account = DB::table('account')->where('guid', $phraseOrGuid)->first();
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
		DB::table('account')->insertGetId(['phrase' => $phrase, 'guid' => $guid]);
		$account = $this->get($phrase);

		// also create a new team for the account
//		$this->webApi->teamService->createTeam($account->id);

		return $account;
	}
}
