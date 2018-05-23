<?php

namespace App\WebAPI\Services\Draft;

use App\WebAPI\Enums\Rating;
use App\WebAPI\Enums\TeamType;
use App\WebAPI\Models\Draft;
use App\WebAPI\Models\Team;
use App\WebAPI\Services\BaseDaoService;

class DraftCPUPickService extends BaseDaoService
{
	/**
	 * @param $draft Draft the draft to process
	 */
	public function cpuPickPlayers($draft) {
		// get teams for draft
		$teams = $this->webApi->teamTranslator->fromDBCollection($this->daos->draft->teamsForDraft($draft->guid));
		$teamMap = [];
		foreach ($teams as $team) {
			$teamMap[$team->guid] = $team;
		}

		// go through and pick sequence until find an unpicked slot
		foreach ($draft->draftSequence as $sequence) {
			if (!$sequence->playerPickedGuid) {
				$team = $teamMap[$sequence->teamGuid];
				if ($team->teamType === TeamType::CPU) {
					// if slot belongs to CPU then make a pick
					$player = $this->pickPlayerForCPU($draft, $team);
					$team->players[] = $player;
					$this->daos->team->updateTeam($this->webApi->teamTranslator->toDBArray($team));
					$sequence->playerPickedGuid = $player->guid;
				} else {
					// if slot belongs to player then done
					break;
				}
			}
		}
	}

	/**
	 * @param $draft Draft the full draft
	 * @param $team Team the CPU team making the pick
	 * @return \App\WebAPI\Models\Player
	 */
	private function pickPlayerForCPU(&$draft, &$team) {
		if (!$team->teamType === TeamType::CPU) {
			throw new \RuntimeException('Draft auto picking being done on a non-cpu team');
		}

		// sort players by rating
		usort($draft->availablePlayers, function ($a, $b) {
			$result = Rating::sort($a->rating, $b->rating);
			if (!$result) {
				$result = strcmp($a->name, $b->name);
			}
			return $result;
		});

		// randomly pick from the top 5 players
		$rollPercent = $this->webApi->rollService->rollPercentile();
		if ($rollPercent <= 50) {
			$pickPos = 0;
		} else if ($rollPercent <= 75) {
			$pickPos = 1;
		} else if ($rollPercent <= 85) {
			$pickPos = 2;
		} else if ($rollPercent <= 94) {
			$pickPos = 3;
		} else {
			$pickPos = 4;
		}

		// pull player out of available players
		$player = $draft->availablePlayers[$pickPos];
		array_splice($draft->availablePlayers, $pickPos, 1);

		return $player;
	}
}
