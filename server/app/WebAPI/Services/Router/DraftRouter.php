<?php

namespace App\WebAPI\Services\Router;

use Illuminate\Http\Request;

class DraftRouter extends BaseRouter
{

	/**
	 * @param \Laravel\Lumen\Routing\Router $router
	 */
	function init($router)
	{
		$that = $this;
		$router->get('/draft/get/{accountGuid}/{teamGuid}', function ($accountGuid, $teamGuid) use($that) {return $that->getDraft($accountGuid, $teamGuid);});
		$router->post('/draft/pick', function (Request $request) use($that) {return $that->makeDraftPick($request->accountGuid, $request->teamGuid, $request->playerGuid);});
	}

	/**
	 * a player picked a player from a draft, save that pick
	 *
	 * @param $accountGuid string
	 * @param $teamGuid string
	 * @param $playerGuid string
	 * @return \App\WebAPI\Models\Draft
	 */
	public function makeDraftPick($accountGuid, $teamGuid, $playerGuid) {
		return $this->webApi->draftService->makePlayerPick($accountGuid, $teamGuid, $playerGuid);
	}

	/**
	 * load/create a draft for the account (if the account is in "draft" status)
	 *
	 * @param $accountGuid string
	 * @param $teamGuid string
	 * @return \App\WebAPI\Models\Draft
	 */
	public function getDraft($accountGuid, $teamGuid) {
		return $this->webApi->draftService->getDraft($accountGuid, $teamGuid);
	}
}

/*
	 *
- /draft/{accountGuid}/{teamId} : gets/creates the current draft; check that the team is in "draft" state before creating
- /draft/pick : perform a player pick and pick all computer picks until the next player
	- post fields: account guid, team guid, draft player guid
	- verifies the account is part of that draft
	- add the chosen player to the team's roster
	- remove the player from the draft's available players roster
	- add picked player to player sequence in draft
	- perform computer picks until next player pick
	- update draft DB object
	- return updated draft object
- /draft/calculatePlayer : calcualtes scores based on rating for a new drafted player
	- post fields: accountGuid, teamGuid, playerGuid
	- calculates scores for that player based on its rating and returns the results
- /draft/complete
	- post fields: accountGuid, teamGuid
	- verifies all players have been calculated
	- sets account's state to season

	 */
