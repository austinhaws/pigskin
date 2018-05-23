import React from "react";
import PropTypes from "prop-types";
import {Tab, Tabs} from "material-ui";
import Enum from '../../../enum/Enum.js';
import TeamTable from "../../components/TeamTable/TeamTable";

const defaultProps = {
	team: undefined,
};

const propTypes = {
	team: PropTypes.object,
};

export default class TeamTableFilter extends React.Component {
	constructor(props) {
		super(props);

		this.state = {
			lineupType: Enum.positionType.OFFENSE,
		};
	}

	render() {
		// sort the data every time because google material is stupid
		const filterRoster = Enum.roster.rosterForPositionType(this.state.lineupType);
		const filteredPlayers = this.props.team ? this.props.team.players.filter(player => filterRoster.includes(player.position)) : [];
		return (
			<React.Fragment>
				<Tabs onChange={value => this.setState({lineupType: value})}>
					{Object.values(Enum.positionType).map(positionType => (
						<Tab key={positionType} label={positionType} selected={this.state.lineupType === positionType} value={positionType} />
					))}
				</Tabs>
				<TeamTable players={filteredPlayers}/>
			</React.Fragment>
		);
	}

}


TeamTableFilter.propTypes = propTypes;
TeamTableFilter.defaultProps = defaultProps;
