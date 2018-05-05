<?php
namespace App\WebAPI\Test\Services;

use App\WebAPI\Services\Mock\RollServiceMock;

class AccountServiceTest extends BaseServiceTest
{
    public function testCreateGet()
    {
		$this->webApiTest->rollService->setRolls([RollServiceMock::INFINITE_WILD_CARD]);

    	$account1 = $this->webApiTest->accountService->create();

    	$account2 = $this->webApiTest->accountService->get($account1->guid);
    	$account3 = $this->webApiTest->accountService->get($account1->phrase);

		$this->assertEquals($account1->phrase, $account2->phrase);
		$this->assertEquals($account1->guid, $account2->guid);
		$this->assertEquals($account1->phrase, $account3->phrase);
		$this->assertEquals($account1->guid, $account3->guid);
    }
}
