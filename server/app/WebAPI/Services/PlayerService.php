<?php

namespace App\WebAPI\Services;

use App\WebAPI\Enums\Rating;
use App\WebAPI\Models\Player;

class PlayerService extends BaseService
{
	/**
	 * creates a base player with no special bonuses
	 *
	 * @param $position string Position enum of the position to create
	 * @param $rating string the rating for which to create the player; pass null to have it randomly picked
	 * @return Player the new player
	 */
	public function createPlayer($position, $rating = Rating::F)
	{
		$ratingUse = $rating ? $rating : $this->webApi->chartService->randomRating();

		$player = new Player();
		$player->name = $this->webApi->nameService->getRandomName();
		$player->guid = $this->webApi->guidService->getNewGUID();
		$player->position = $position;
		$player->rating = $ratingUse;
		$player->passSkill = 1;
		$player->runSkill = 1;
		$player->specialSkill = 1;

		return $player;
	}

	/**
	 * @param $player Player the player to boost
	 */
	public function boostPlayer($player) {
		// roll run/pass/special chart result
		$skill = $this->webApi->chartService->playerUpgradeType($player->position);

		// give bonus to that skill based on player rating
		$player->{$skill} += $this->webApi->rollService->rollRatingSkillBonus($player->position);
	}

}
