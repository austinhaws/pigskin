<?php

namespace App\WebAPI\Enums;

interface Roster {

	public const MAX_ROSTER_SIZE = 40;

	public const OFFENSE_MINIMUM = [
		Position::QUARTER_BACK,
		Position::HALF_BACK,
		Position::FULL_BACK,
		Position::TIGHT_END,
		Position::WIDE_RECEIVER,
		Position::WIDE_RECEIVER,
		Position::OFFENSIVE_LINE,
		Position::OFFENSIVE_LINE,
		Position::OFFENSIVE_LINE,
		Position::OFFENSIVE_LINE,
		Position::OFFENSIVE_LINE,
	];

	public const DEFENSE_MINIMUM = [
		Position::SAFETY,
		Position::SAFETY,
		Position::CORNER_BACK,
		Position::CORNER_BACK,
		Position::LINE_BACKER,
		Position::LINE_BACKER,
		Position::LINE_BACKER,
		Position::DEFENSIVE_LINE,
		Position::DEFENSIVE_LINE,
		Position::DEFENSIVE_LINE,
		Position::DEFENSIVE_LINE,
	];

	public const SPECIAL_MINIMUM = [
		Position::PUNTER,
		Position::KICKER,
	];
}
