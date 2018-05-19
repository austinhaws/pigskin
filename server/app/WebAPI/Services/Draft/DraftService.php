<?php

namespace App\WebAPI\Services\Draft;

use App\WebAPI\Enums\TeamStage;
use App\WebAPI\Models\Draft;
use App\WebAPI\Models\Player;
use App\WebAPI\Services\BaseService;

class DraftService extends BaseService
{
	/**
	 * @param $accountGuid string
	 * @param $teamGuid string
	 * @return Draft
	 */
	public function getDraft($accountGuid, $teamGuid) {
		$team = $this->webApi->teamService->get($accountGuid, $teamGuid);
		// check that the team is in draft mode
		if ($team->stage !== TeamStage::DRAFT) {
			throw new \RuntimeException('Team is not in draft stage when getting draft');
		}

		$draftDB = $this->webApi->draftDao->selectDraftForTeam($team->id);
		if ($draftDB) {
			$draft = new Draft();
			$draft->id = $draftDB->id;
			$draft->availablePlayers = $this->webApi->jsonService->jsonToObjectArray($draftDB->available_players, Player::class);
			$draft->draftSequence = json_decode($draftDB->draft_sequence);
			$draft->state = $draftDB->state;
		} else {
			// start a new draft
			$draft = $this->webApi->draftCreateService->createDraft($team->guid);
		}

		// need to convert draft fields to camel case for js consumption
		$this->webApi->jsonService->snakeCaseToCamelCase($draft);
		return $draft;
	}
}
