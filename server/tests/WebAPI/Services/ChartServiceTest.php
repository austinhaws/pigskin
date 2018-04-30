<?php

use App\WebAPI\Enums\Position;

class ChartServiceTest extends BaseServiceTest
{
    public function testRollChart()
    {
    	$this->webApi->rollService->setRolls([100]);
		$upgradeType = $this->webApi->chartService->playerUpgradeType(Position::QUARTER_BACK);
		$this->assertEquals('run', $upgradeType);

    	$this->webApi->rollService->setRolls([1]);
		$upgradeType = $this->webApi->chartService->playerUpgradeType(Position::QUARTER_BACK);
		$this->assertEquals('pass', $upgradeType);
    }
}
