<?php

namespace App\WebAPI\Services;

use App\WebAPI\Enums\Rating;
use App\WebAPI\Enums\Roster;
use App\WebAPI\Models\Player;

class PlayerService extends BaseDaoService
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
		$player->passSkill = $this->startingSkill($position, 'pass');
		$player->runSkill = $this->startingSkill($position, 'run');
		$player->kickSkill = $this->startingSkill($position, 'kick');
		$player->age = $this->webApi->chartService->playerAge();

		return $player;
	}

	private function startingSkill($position, $skill) {
		$isKick = array_search($position, Roster::KICK_MINIMUM) !== false;
		switch ($skill) {
			case 'run':
			case 'pass':
				$value = $isKick ? 0 : 1;
				break;
			case 'kick':
				$value = $isKick ? 1 : 0;
				break;
			default:
				throw new \RuntimeException('startingSkill: Unknown skill - ' . $skill);
		}
		return $value;
	}

	/**
	 * @param $player Player the player to boost
	 */
	public function boostPlayer($player) {
		// roll run/pass/kick chart result
		$skill = $this->webApi->chartService->playerUpgradeType($player->position);

		// give bonus to that skill based on player rating
		$player->{$skill . 'Skill'} += $this->webApi->rollService->rollRatingSkillBonus($player->rating);
	}

}
