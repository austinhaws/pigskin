<?php

namespace App\WebAPI\Enums;

interface ChartType {
	// run vs pass upgrade type by position
	public const PLAYER_UPGRADE_TYPE = 'Upgrade Type By Player Type';

	// 1-5 rating level of doing an upgrade (size of upgrade dice and # of rolls)
	public const UPGRADE_RATING = 'Upgrade Rating';

	// starting age of a player
	public const PLAYER_STARTING_AGE = 'Player Starting Age';

	// what to roll for a rating's skill bonus roll
	public const RATING_SKILL_BONUS_ROLL = 'Rating Skill Bonus Roll';
}
