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
		$result = $this->webApiTest->draftService->getDraft($account->guid, $team->guid);
		$draft = $result['draft'];

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
		$result = $this->webApiTest->draftService->getDraft($account->guid, $team->guid);
		$draft2 = $result['draft'];
		$this->assertEquals($draft2->guid, $draft->guid);

		$sequence = $draft2->draftSequence[0];
		$this->assertNotNull($sequence->playerPickedGuid);
		$found = false;
		foreach ($result['teams'] as $team) {
			foreach ($team->players as $player) {
				$found = $found || $player->guid === $sequence->playerPickedGuid;
			}
		}
		$this->assertTrue($found);
	}

	public function testMakePlayerPick()
	{
		// create an account/team
		$this->webApiTest->rollService->setRolls([RollServiceMock::INFINITE_WILD_CARD]);

		$account = $this->webApiTest->accountService->create();
		$team = $this->webApiTest->teamService->get($account->guid);

		// create draft
		$result = $this->webApiTest->draftService->getDraft($account->guid, $team->guid);
		$draft = $result['draft'];

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
		$this->assertNotNull($result['teams']);

		$playerGuid = $player->guid;
		$teamGuid = $account->team->guid;
		$team = array_first(array_filter($result['teams'], function ($team) use($teamGuid) {
			return $team->guid === $teamGuid;
		}));
		$teamPlayer = array_filter($team->players, function ($player) use ($playerGuid) {
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
