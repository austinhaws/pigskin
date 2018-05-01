<?php

namespace App\WebAPI\Test\Services;

use App\WebAPI\Enums\Position;

class ChartServiceTest extends BaseServiceTest
{
    public function testRollChart()
    {
    	$this->webApiTest->rollService->setRolls([100]);
		$upgradeType = $this->webApiTest->chartService->playerUpgradeType(Position::QUARTER_BACK);
		$this->assertEquals('run', $upgradeType);

    	$this->webApiTest->rollService->setRolls([1]);
		$upgradeType = $this->webApiTest->chartService->playerUpgradeType(Position::QUARTER_BACK);
		$this->assertEquals('pass', $upgradeType);
    }
}
