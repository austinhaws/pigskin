<?php

namespace App\WebAPI\Test\Services;

use App\WebAPI\Enums\Position;
use App\WebAPI\Services\Mock\RollServiceMock;

class PlayerServiceTest extends BaseServiceTest
{
    public function testCreatePlayer()
    {
    	$this->webApiTest->rollService->setRolls([RollServiceMock::INFINITE_WILD_CARD]);
    	$player = $this->webApiTest->playerService->createPlayer(Position::QUARTER_BACK);
    	$this->assertNotNull($player->age);
    	$this->assertTrue(strlen($player->name) > 0);
    }

    public function testBoostPlayer() {
		$this->webApiTest->rollService->setRolls([25, 24, 23, 1]);

    	$player = $this->webApiTest->playerService->createPlayer(Position::DEFENSIVE_LINE);
    	$this->assertEquals(1, $player->runSkill);
    	$this->assertEquals(1, $player->passSkill);
    	$this->assertEquals(0, $player->specialSkill);

    	$this->webApiTest->playerService->boostPlayer($player);
    	$this->assertEquals(2, $player->runSkill);
    	$this->assertEquals(1, $player->passSkill);
    	$this->assertEquals(0, $player->specialSkill);
	}
}
