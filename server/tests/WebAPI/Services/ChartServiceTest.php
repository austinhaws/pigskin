<?php

namespace App\WebAPI\Test\Services;

use App\WebAPI\Enums\Position;

class ChartServiceTest extends BaseServiceTest
{
    public function testRollChart()
    {
    	$this->webApiTest->rollService->setRolls([100]);
		$upgradeType = $this->webApiTest->chartService->playerUpgradeType(Position::QUARTER_BACK);
		$this->assertEquals('pass', $upgradeType);

    	$this->webApiTest->rollService->setRolls([1]);
		$upgradeType = $this->webApiTest->chartService->playerUpgradeType(Position::QUARTER_BACK);
		$this->assertEquals('run', $upgradeType);
    }

    public function testRollDetailChart() {
		$this->webApiTest->rollService->setRolls([100]);
		$age = $this->webApiTest->chartService->playerAge();
    	$this->assertEquals(25, $age);

		$this->webApiTest->rollService->setRolls([1]);
		$age = $this->webApiTest->chartService->playerAge();
    	$this->assertEquals(18, $age);

		$this->webApiTest->rollService->setRolls([80]);
		$age = $this->webApiTest->chartService->playerAge();
    	$this->assertEquals(21, $age);
	}
}
