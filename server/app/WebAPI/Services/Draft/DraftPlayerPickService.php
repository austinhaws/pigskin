<?php

namespace App\WebAPI\Services\Draft;

use App\WebAPI\Models\Draft;
use App\WebAPI\Models\Team;
use App\WebAPI\Services\BaseDaoService;

class DraftPlayerPickService extends BaseDaoService
{
	/**
	 * @param Draft $draft
	 * @param string $accountGuid
	 * @param Team $playerTeam
	 * @param string $playerGuid
	 * @return array draft and team after the picks
	 */
	public function playerTeamPickDraftPlayer(Draft $draft, string $accountGuid, Team $playerTeam, string $playerGuid) {
		$result = ['draft' => null, 'teams' => null];
		foreach ($draft->draftSequence as $sequence) {
			if (!$sequence->playerPickedGuid) {
				if ($sequence->teamGuid !== $playerTeam->guid) {
					throw new \RuntimeException("Next pick does not belong to this playerTeam: {$accountGuid}->{$playerTeam->guid} != {$sequence->teamGuid}" );
				}

				// find player in draft available players
				$playerIdx = 0;
				for (; $playerIdx < count($draft->availablePlayers); $playerIdx++) {
					if ($draft->availablePlayers[$playerIdx]->guid === $playerGuid) {
						break;
					}
				}
				if ($playerIdx >= count($draft->availablePlayers)) {
					var_dump($draft->availablePlayers);
					throw new \RuntimeException("Picked player not found in draft: {$draft->guid}->{$playerGuid}");
				}

				// remove from available players
				$pickedPlayer = $draft->availablePlayers[$playerIdx];
				array_splice($draft->availablePlayers, $playerIdx, 1);

				// record to sequence that the player was picked
				$sequence->playerPickedGuid = $pickedPlayer->guid;

				// add to player team and save
				$playerTeam->players[] = $pickedPlayer;
				$this->daos->team->updateTeam($this->webApi->teamTranslator->toDBArray($playerTeam));

				// keep picking CPU picks
				$this->webApi->draftCPUPickService->cpuPickPlayers($draft);

				// save draft with updated cpu picks
				$this->daos->draft->updateDraft($this->webApi->draftTranslator->toDBArray($draft));

				// get the changed draft and team
				$result = $this->webApi->draftService->getDraft($accountGuid, $playerTeam->guid);
				break;
			}
		}

		return $result;
	}
}
