<?php

namespace App\WebAPI\Test\Services;

use App\WebAPI\Enums\Position;
use App\WebAPI\Enums\Roster;
use App\WebAPI\Services\Mock\RollServiceMock;
use App\WebAPI\Services\TeamService;

class TeamServiceTest extends BaseServiceTest
{
    public function testCreateGet()
    {
    	$this->webApiTest->rollService->setRolls([RollServiceMock::INFINITE_WILD_CARD]);
    	$account = $this->webApiTest->accountService->create();

		$teamPositions = array_merge(
			Roster::OFFENSE_MINIMUM,
			Roster::DEFENSE_MINIMUM,
			Roster::SPECIAL_MINIMUM
		);


		$team = $this->webApiTest->teamService->create($account->id);
    	$this->assertEquals(count($teamPositions), count($team->players));

    	// count up boosted stats and make sure they add up to 10
    	$numberUpgrades = array_reduce($team->players, function ($total, $player) {
    		if ($player->position === Position::KICKER || $player->position === Position::PUNTER) {
				$total += $player->specialSkill - 1;
			} else {
    			$total += $player->runSkill - 1 + $player->passSkill - 1;
			}
			return $total;
		}, 0);
    	$this->assertEquals(TeamService::NUMBER_STARTING_BOOSTS, $numberUpgrades);
    }
}
