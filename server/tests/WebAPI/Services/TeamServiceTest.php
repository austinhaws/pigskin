<?php

namespace App\WebAPI\Test\Services;

use App\WebAPI\Enums\Position;
use App\WebAPI\Enums\PositionType;
use App\WebAPI\Enums\Roster;
use App\WebAPI\Enums\TeamStage;
use App\WebAPI\Enums\TeamType;
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
			Roster::KICK_MINIMUM
		);


		$team = $this->webApiTest->teamService->create($account->id, TeamType::PLAYER);
    	$this->assertEquals(count($teamPositions), count($team->players));
    	$this->assertEquals(TeamStage::DRAFT, $team->stage);

    	// count up boosted stats and make sure they add up to 10
    	$numberUpgrades = array_reduce($team->players, function ($total, $player) {
    		if ($player->position === Position::KICKER || $player->position === Position::PUNTER) {
				$total += $player->kickSkill - 1;
			} else {
    			$total += $player->runSkill - 1 + $player->passSkill - 1;
			}
			return $total;
		}, 0);
    	$this->assertEquals(TeamService::NUMBER_STARTING_BOOSTS, $numberUpgrades);

		$this->assertEquals(3, count($team->lineups));

		$lineupTypes = array_map(function ($lineup) {
			return $lineup->positionType;
		}, $team->lineups);
		$this->assertNotSame(false, array_search(PositionType::KICK, $lineupTypes));
		$this->assertNotSame(false, array_search(PositionType::OFFENSE, $lineupTypes));
		$this->assertNotSame(false, array_search(PositionType::DEFENSE, $lineupTypes));
    }

    public function testCPU() {
		$this->webApiTest->rollService->setRolls([RollServiceMock::INFINITE_WILD_CARD]);
		$team = $this->webApiTest->teamService->create(null, TeamType::CPU);
		$this->assertEquals(TeamType::CPU, $team->team_type);

		$account = $this->webApiTest->accountService->create();
		$team = $this->webApiTest->teamService->create($account->id, TeamType::PLAYER);
		$this->assertEquals(TeamType::PLAYER, $team->team_type);
	}

	public function testTeamCreateExceptions() {
		$this->webApiTest->rollService->setRolls([RollServiceMock::INFINITE_WILD_CARD]);

		$account = $this->webApiTest->accountService->create();
		try {
			$this->webApiTest->teamService->create($account->id, TeamType::CPU);
		} catch (\RuntimeException $exception) {
			$this->assertEquals('CPU teams can not have an account', $exception->getMessage());
		}

		try {
			$this->webApiTest->teamService->create(null, TeamType::PLAYER);
		} catch (\RuntimeException $exception) {
			$this->assertEquals('Non-CPU teams must have an account', $exception->getMessage());
		}
	}
}
