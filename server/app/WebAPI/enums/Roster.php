<?php

namespace App\WebAPI\Enums;

class Roster extends BaseEnum {

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

	public const KICK_MINIMUM = [
		Position::PUNTER,
		Position::KICKER,
	];

	/**
	 * @param $positionType String PositionType::... enum
	 * @return array
	 */
	public static function rosterForPositionType($positionType) {
		switch ($positionType) {
			case PositionType::KICK:
				$roster = Roster::KICK_MINIMUM;
				break;
			case PositionType::OFFENSE:
				$roster = Roster::OFFENSE_MINIMUM;
				break;
			case PositionType::DEFENSE:
				$roster = Roster::DEFENSE_MINIMUM;
				break;
			default:
				throw new \RuntimeException("Unknown position type: $positionType");
		}
		return $roster;
	}

	static function who()
	{
		return __CLASS__;
	}
}
