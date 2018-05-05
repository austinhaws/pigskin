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
    }
}
