/**
 * This matches the enums in the server's Enums package. There should be a test
 * written that takes the enums from a webservice and compares them with
 * with this JS version of them to check they all exist and that their values
 * are all the same.
 *
 * By spelling them out manually, code completion in JS is now possible which is rad.
 */
import Position from './Position';
import PositionType from "./PositionType";
import Rating from "./Rating";
import Roster from "./Roster";

export default {
	position: Position,
	positionType: PositionType,
	rating: Rating,
	roster: Roster,
};
