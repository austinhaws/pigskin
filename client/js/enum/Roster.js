import Position from './Position';
import PositionType from "./PositionType";

const Roster = {
	MAX_ROSTER_SIZE: 40,

	OFFENSE_MINIMUM: [
		Position.QUARTER_BACK,
		Position.HALF_BACK,
		Position.FULL_BACK,
		Position.TIGHT_END,
		Position.WIDE_RECEIVER,
		Position.WIDE_RECEIVER,
		Position.OFFENSIVE_LINE,
		Position.OFFENSIVE_LINE,
		Position.OFFENSIVE_LINE,
		Position.OFFENSIVE_LINE,
		Position.OFFENSIVE_LINE,
	],

	DEFENSE_MINIMUM: [
		Position.SAFETY,
		Position.SAFETY,
		Position.CORNER_BACK,
		Position.CORNER_BACK,
		Position.LINE_BACKER,
		Position.LINE_BACKER,
		Position.LINE_BACKER,
		Position.DEFENSIVE_LINE,
		Position.DEFENSIVE_LINE,
		Position.DEFENSIVE_LINE,
		Position.DEFENSIVE_LINE,
	],

	KICK_MINIMUM: [
		Position.PUNTER,
		Position.KICKER,
	],

	rosterForPositionType: positionType =>  {
		let roster;
		switch (positionType) {
			case PositionType.KICK:
				roster = Roster.KICK_MINIMUM;
				break;
			case PositionType.OFFENSE:
				roster = Roster.OFFENSE_MINIMUM;
				break;
			case PositionType.DEFENSE:
				roster = Roster.DEFENSE_MINIMUM;
				break;
			default:
				throw `Unknown position type: ${positionType}`;
		}
		return roster;
	},
};

export default Roster;
