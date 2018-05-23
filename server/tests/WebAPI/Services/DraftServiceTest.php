<?php

namespace App\WebAPI\Test\Services;

use App\WebAPI\Enums\DraftState;
use App\WebAPI\Services\Draft\DraftCreateService;
use App\WebAPI\Services\Mock\RollServiceMock;

class DraftServiceTest extends BaseServiceTest
{
	public function testCreateDraftGet()
	{
		$this->webApiTest->rollService->setRolls([RollServiceMock::INFINITE_WILD_CARD]);

		$account = $this->webApiTest->accountService->create();
		$team = $this->webApiTest->teamService->get($account->guid);
		$draft = $this->webApiTest->draftService->getDraft($account->guid, $team->guid);

		$this->assertTrue(count($draft->availablePlayers) <= DraftCreateService::DRAFT_SIZE);
		$this->assertEquals(count($draft->draftSequence), (DraftCreateService::NUMBER_CPUS + 1) * 5);
		$this->assertEquals($draft->state, DraftState::IN_PROGRESS);
		$this->assertTrue($this->webApiTest->guidService->isGuid($draft->guid), $draft->guid);

		// - draft sequence has guids for team ids
		$foundPlayer = false;
		foreach ($draft->draftSequence as $sequence) {
			$teamGuid = $sequence->teamGuid;
			$this->assertTrue($this->webApiTest->guidService->isGuid($teamGuid), $teamGuid);
			$foundPlayer = $foundPlayer || $sequence->teamGuid === $team->guid;
			if (!$foundPlayer) {
				$this->assertNotNull($sequence->playerPickedGuid);
				$this->assertTrue($this->webApiTest->guidService->isGuid($sequence->playerPickedGuid));
			}
		}

		// get an already existing draft
		$draft2 = $this->webApiTest->draftService->getDraft($account->guid, $team->guid);
		$this->assertEquals($draft2->id, $draft->id);
	}

	public function testMakePlayerPick()
	{
		// create an account/team
		$this->webApiTest->rollService->setRolls([RollServiceMock::INFINITE_WILD_CARD]);

		$account = $this->webApiTest->accountService->create();
		$team = $this->webApiTest->teamService->get($account->guid);

		// create draft
		$draft = $this->webApiTest->draftService->getDraft($account->guid, $team->guid);

		// check that the next pick to make is the player's pick
		$found = false;
		foreach ($draft->draftSequence as $draftSequence) {
			if (!$draftSequence->playerPickedGuid) {
				$this->assertEquals($team->guid, $draftSequence->teamGuid);
				$found = true;
				break;
			}
		}
		$this->assertTrue($found, 'Should have found an empty draft pick A');

		// pick an available_player
		shuffle($draft->availablePlayers);
		$player = array_shift($draft->availablePlayers);
		$result = $this->webApiTest->draftService->makePlayerPick($account->guid, $team->guid, $player->guid);

		// make sure the draft and team update correctly
		$this->assertNotNull($result['draft']);
		$this->assertNotNull($result['team']);

		$playerGuid = $player->guid;
		$teamPlayer = array_filter($result['team']->players, function ($player) use ($playerGuid) {
			return $player->guid === $playerGuid;
		});
		$this->assertEquals(1, count($teamPlayer));

		// player should be making the next pick (cpu players already picked)
		$found = false;
		foreach ($draft->draftSequence as $draftSequence) {
			if (!$draftSequence->playerPickedGuid) {
				$this->assertEquals($team->guid, $draftSequence->teamGuid);
				$found = true;
				break;
			}
		}
		$this->assertTrue($found, 'Should have found an empty draft pick B');

	}
}
