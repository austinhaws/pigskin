<?php

namespace App\WebAPI\Enums;

class ChartType extends BaseEnum {
	// run vs pass upgrade type by position
	public const PLAYER_UPGRADE_TYPE = 'Upgrade Type By Player Type';

	// A-F grades based on rating tier (higher tiers have better ratings)
	public const UPGRADE_RATING = 'Upgrade Rating';

	// starting age of a player
	public const PLAYER_STARTING_AGE = 'Player Starting Age';

	// what to roll for a rating's skill bonus roll
	public const RATING_SKILL_BONUS_ROLL = 'Rating Skill Bonus Roll';

	static function who()
	{
		return __CLASS__;
	}
}
