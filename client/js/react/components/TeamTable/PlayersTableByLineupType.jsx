import React from "react";
import PropTypes from "prop-types";
import {Tab, Tabs} from "material-ui";
import Enum from '../../../enum/Enum.js';
import PlayersTable from "./PlayersTable";
import Column from "../TableWrapper/Column";

const defaultProps = {
	players: undefined,
	hideColumns: [],
	addColumns: [],
};

const propTypes = {
	players: PropTypes.arrayOf(PropTypes.object),
	hideColumns: PropTypes.arrayOf(PropTypes.string),
	addColumns: PropTypes.arrayOf(PropTypes.instanceOf(Column)),
};

export default class PlayersTableByLineupType extends React.Component {
	constructor(props) {
		super(props);

		this.state = {
			lineupType: Enum.positionType.OFFENSE,
		};
	}

	render() {
		// sort the data every time because google material is stupid
		const filterRoster = Enum.roster.rosterForPositionType(this.state.lineupType);
		const filteredPlayers = this.props.players ? this.props.players.filter(player => filterRoster.includes(player.position)) : [];
		return (
			<React.Fragment>
				<Tabs onChange={value => this.setState({lineupType: value})}>
					{Object.values(Enum.positionType).map(positionType => (
						<Tab key={positionType} label={positionType} selected={this.state.lineupType === positionType} value={positionType} />
					))}
				</Tabs>
				<PlayersTable players={filteredPlayers} hideColumns={this.props.hideColumns} addColumns={this.props.addColumns}/>
			</React.Fragment>
		);
	}

}

PlayersTableByLineupType.propTypes = propTypes;
PlayersTableByLineupType.defaultProps = defaultProps;
