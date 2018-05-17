<?php

namespace App\WebAPI\Services\Draft;

use App\WebAPI\Dao\DraftDao;
use App\WebAPI\Enums\TeamStage;
use App\WebAPI\Models\Draft;
use App\WebAPI\Models\Player;
use App\WebAPI\Services\BaseService;

class DraftService extends BaseService
{
	/** @var DraftDao */
	private $draftDao;

	public function __construct($webApi)
	{
		parent::__construct($webApi);
		$this->draftDao = new DraftDao();
	}

	/**
	 * @param $accountId int
	 * @param $teamId int
	 * @return Draft
	 */
	public function getDraft($accountId, $teamId) {
		$team = $this->webApi->teamService->get($accountId, $teamId);

		// check that the team is in draft mode
		if ($team->stage !== TeamStage::DRAFT) {
			throw new \RuntimeException('Team is not in draft stage when getting draft');
		}

		$draftDB = $this->draftDao->selectDraftForTeam($team->id);
		if ($draftDB) {
			$draft = new Draft();
			$draft->id = $draftDB->id;
			$draft->availablePlayers = $this->webApi->jsonService->jsonToObjectArray($draftDB->available_players, Player::class);
			$draft->draftSequence = json_decode($draftDB->draft_sequence);
			$draft->state = $draftDB->state;
		} else {
			// start a new draft
			$draft = $this->webApi->draftCreateService->createDraft($team->id);
		}

		// need to convert draft fields to camel case for js consumption
		$this->webApi->jsonService->snakeCaseToCamelCase($draft);
		return $draft;
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
}
