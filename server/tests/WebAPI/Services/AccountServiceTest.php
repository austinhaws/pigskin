<?php

use App\WebAPI\WebAPI;

class AccountServiceTest extends TestCase
{
    public function testCreateGet()
    {
    	$webApi = new WebAPI();

    	$account1 = $webApi->accountService->create();

    	$account2 = $webApi->accountService->get($account1->guid);
    	$account3 = $webApi->accountService->get($account1->phrase);

		$this->assertEquals($account1->phrase, $account2->phrase);
		$this->assertEquals($account1->guid, $account2->guid);
		$this->assertEquals($account1->phrase, $account3->phrase);
		$this->assertEquals($account1->guid, $account3->guid);
    }
}
