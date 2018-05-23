<?php

namespace App\WebAPI\Services\Router;

use App\WebAPI\Services\Mock\RollServiceMock;

class DraftRouterTest extends BaseRouterTest
{
	public function testDraftGet()
	{
		$this->webApiTest->rollService->setRolls([RollServiceMock::INFINITE_WILD_CARD]);

		// create/get account
		$account = $this->webApiTest->accountService->create();

		// get new draft for account/team
		$draft1 = $this->decodeJsonFromResponse($this->get("draft/get/{$account->guid}/{$account->team->guid}"));

		$this->assertNotNull($draft1);
		$this->assertNotNull($draft1->guid);

		// get existing draft for account/team
		$draft2 = $this->decodeJsonFromResponse($this->get("draft/get/{$account->guid}/{$account->team->guid}"));

		$this->assertNotNull($draft2);
		$this->assertEquals($draft1->guid, $draft2->guid);
	}

	public function testDraftMakePick() {
		$this->webApiTest->rollService->setRolls([RollServiceMock::INFINITE_WILD_CARD]);

		// create/get account
		$account = $this->webApiTest->accountService->create();

		// get new draft for account/team
		$draft1 = $this->decodeJsonFromResponse($this->get("draft/get/{$account->guid}/{$account->team->guid}"));

		// get an available player guid
		shuffle($draft1->availablePlayers);
		$pickedPlayer = $draft1->availablePlayers[0];

		// pick that player
		$response = $this->post('draft/pick', [
			'accountGuid' => $account->guid,
			'teamGuid' => $account->team->guid,
			'playerGuid' => $pickedPlayer->guid,
		]);

		$results = json_decode($response->response->content());

		// make sure team got new player
		$pickedPlayerGuid = $pickedPlayer->guid;
		$this->assertTrue($this->playersHasPlayerGuid($results->team->players, $pickedPlayerGuid));

		// make sure draft does not have that player
		$this->assertFalse($this->playersHasPlayerGuid($results->draft->availablePlayers, $pickedPlayerGuid));

		// select draft/team and make sure from the DB they are in this correct state
		$draft = $this->webApiTest->draftService->getDraft($account->guid, $account->team->guid);
		$this->assertFalse($this->playersHasPlayerGuid($draft->availablePlayers, $pickedPlayerGuid));

		$team = $this->webApiTest->teamService->get($account->guid, $account->team->guid);
		$this->assertTrue($this->playersHasPlayerGuid($team->players, $pickedPlayerGuid));
	}

	/**
	 * @param array $players
	 * @param string $playerGuid
	 * @return bool
	 */
	private function playersHasPlayerGuid(array $players, string $playerGuid) {
		return 0 < count(array_filter($players, function ($player) use($playerGuid) {
			return $player->guid === $playerGuid;
		}));
	}
}
