<?php

namespace App\WebAPI\Services;

use App\WebAPI\Enums\ChartType;

class RollService extends BaseService
{
	/**
	 * generates a number
	 *
	 * @param $min int minimum value
	 * @param $max int maximum value
	 * @return int random number
	 */
	public function roll($min, $max) {
		return mt_rand($min, $max);
	}

	/**
	 * @return int random number between 1 and 100
	 */
	public function rollPercentile() {
		return $this->roll(1, 100);
	}

	/**
	 * @param $rating string Rating:: enum value
	 * @return int the resulting bonus
	 */
	public function rollRatingSkillBonus($rating)
	{
		return $this->roll(1, $this->webApi->chartService->lookupChartValue(ChartType::RATING_SKILL_BONUS_ROLL, $rating));
	}
}
