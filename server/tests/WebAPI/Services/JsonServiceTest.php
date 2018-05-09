<?php

namespace App\WebAPI\Test\Services;

use App\WebAPI\Enums\Position;
use App\WebAPI\Models\Player;

class JsonServiceTest extends BaseServiceTest
{
    public function testGuid()
    {
    	$startPlayer = new Player();
    	$startPlayer->position = Position::QUARTER_BACK;
    	$jsonString = json_encode([$startPlayer]);

    	$players = $this->webApiTest->jsonService->jsonToObjectArray($jsonString, Player::class);

    	$this->assertEquals($startPlayer->position, $players[0]->position);
    }
}
