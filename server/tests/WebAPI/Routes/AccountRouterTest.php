<?php

namespace App\WebAPI\Services\Router;

class AccountRouterTest extends BaseRouterTest
{
	/**
	 * 	$router->get('account/create', function () use($that) {return $that->accountCreate();});
	 */
	public function testAccountCreate() {
		$account = $this->decodeJsonFromResponse($this->get('account/create'));
		$this->assertFalse(isset($account->id));
		$this->assertNotNull($account->phrase);
		$this->assertNotNull($account->guid);
	}

	/**
	 * $router->get('account/get/{phraseOrGuid}', function ($phraseOrGuid) use($that) {return $that->accountGet($phraseOrGuid);});
	 */
	public function testAccountGet() {
		$account = $this->decodeJsonFromResponse($this->get('account/create'));

		$account1 = $this->decodeJsonFromResponse($this->get("account/get/{$account->phrase}"));
		$this->assertEquals($account->guid, $account1->guid);

		$account2 = $this->decodeJsonFromResponse($this->get("account/get/{$account->guid}"));
		$this->assertEquals($account->guid, $account2->guid);
	}
}
