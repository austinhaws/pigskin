<?php
namespace App\WebAPI\Test\Services;

use App\WebAPI\Services\Mock\RollServiceMock;

class AccountServiceTest extends BaseServiceTest
{
    public function testCreateGet()
    {
		$this->webApiTest->rollService->setRolls([RollServiceMock::INFINITE_WILD_CARD]);

    	$account1 = $this->webApiTest->accountService->create();
    	$this->assertNotNull($account1);

    	$account2 = $this->webApiTest->accountService->get($account1->guid);
		$this->assertEquals($account1->phrase, $account2->phrase);
		$this->assertEquals($account1->guid, $account2->guid);
    	$account3 = $this->webApiTest->accountService->get($account1->phrase);
		if (!$account1 || !$account3) {
			// if this fails, then a GUID is being registered as a phrase or vice versa
			var_dump(($account1 ? "1 exists ({$account1->phrase})" : '1 dead') . ' / ' . ($account3 ? "3 exists ({$account3->phrase})" : '3 dead'));
		}
		$this->assertEquals($account1->phrase, $account3->phrase);
		$this->assertEquals($account1->guid, $account3->guid);
    }
}
