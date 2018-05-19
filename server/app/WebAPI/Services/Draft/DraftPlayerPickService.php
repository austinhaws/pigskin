<?php

namespace App\WebAPI\Services\Draft;

use App\WebAPI\Models\Draft;
use App\WebAPI\Models\Team;
use App\WebAPI\Services\BaseService;

class DraftPlayerPickService extends BaseService
{
	/**
	 * @param Draft $draft
	 * @param string $accountGuid
	 * @param Team $playerTeam
	 * @param string $playerGuid
	 */
	public function playerTeamPickDraftPlayer(Draft $draft, string $accountGuid, Team $playerTeam, string $playerGuid) {
		foreach ($draft->draftSequence as $sequence) {
			if (!$sequence->playerPickedGuid) {
				if ($sequence->teamGuid !== $playerTeam->guid) {
					throw new \RuntimeException("Next pick does not belong to this playerTeam: {$accountGuid}->{$playerTeam->guid}" );
				}

				// find player in draft available players
				$playerIdx = 0;
				for (; $playerIdx < count($draft->availablePlayers); $playerIdx++) {
					if ($draft->availablePlayers[$playerIdx]->guid === $playerGuid) {
						break;
					}
				}
				if ($playerIdx >= count($draft->availablePlayers)) {
					throw new \RuntimeException("Picked player not found in draft: {$draft->id}->${$playerGuid}");
				}

				// remove from available players
				$pickedPlayer = $draft->availablePlayers[$playerIdx];
				array_splice($draft->availablePlayers, $playerIdx, 1);

				// add to sequence
				$sequence->playerPickedGuid = $pickedPlayer->guid;

				// add to player team
				$playerTeam->players[] = $pickedPlayer;

				// DAO: save draft
				$this->webApi->draftDao->updateDraft($this->webApi->draftTranslator->toDBArray($draft));

				// DAO: save to playerTeam
				$this->webApi->teamDao->updateTeam($this->webApi->teamTranslator->toDBArray($playerTeam));
				break;
			}
		}
	}
}
