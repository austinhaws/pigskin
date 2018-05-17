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
    	$team = $this->webApiTest->teamService->get($account->id);

    	$draft = $this->webApiTest->draftService->getDraft($account->id, $team->id);

    	$this->assertEquals(count($draft->availablePlayers), DraftCreateService::DRAFT_SIZE);
    	$this->assertEquals(count($draft->draftSequence), (DraftCreateService::NUMBER_CPUS + 1) * 5);
    	$this->assertEquals($draft->state, DraftState::IN_PROGRESS);
		$this->assertTrue($this->typeCompare->isGuid($draft->guid), $draft->guid);

		// - draft sequence has guids for team ids
		foreach ($draft->draftSequence as $sequence) {
			$teamGuid = $sequence['teamGuid'];
			$this->assertTrue($this->typeCompare->isGuid($teamGuid), $teamGuid);
		}

    	// get an already existing draft
    	$draft2 = $this->webApiTest->draftService->getDraft($account->id, $team->id);
    	$this->assertEquals($draft2->id, $draft->id);
    }
}
