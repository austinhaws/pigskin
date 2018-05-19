<?php

namespace App\WebAPI\Services\Draft;

use App\WebAPI\Enums\TeamStage;
use App\WebAPI\Models\Draft;
use App\WebAPI\Services\BaseService;

class DraftService extends BaseService
{
	/**
	 * get the draft for an account, creating one if not found IF team in the DRAFT stage
	 *
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

		$draft = $this->webApi->draftTranslator->fromDBObj($this->webApi->draftDao->selectDraftForTeam($team->id));
		if (!$draft) {
			// start a new draft
			$draft = $this->webApi->draftCreateService->createDraft($team->guid);
		}
		return $draft;
	}

	/**
	 * a non-cpu team has picked a player from the draft
	 *
	 * @param $accountGuid
	 * @param $playerGuid
	 * @return \App\WebAPI\Models\Draft
	 */
	public function makePlayerPick($accountGuid, $playerGuid)
	{
		$team = $this->webApi->teamService->get($accountGuid);
		$draft = $this->webApi->draftService->getDraft($accountGuid, $team->guid);
		return $this->webApi->draftPlayerPickService->playerTeamPickDraftPlayer($draft, $accountGuid, $team, $playerGuid);
	}
}
