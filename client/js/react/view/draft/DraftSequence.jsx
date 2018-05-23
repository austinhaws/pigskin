import React from "react";
import PropTypes from "prop-types";
import TableWrapper from "../../components/TableWrapper/TableWrapper";
import _ from 'lodash';
import Column from "../../components/TableWrapper/Column";
import DataType from "../../components/TableWrapper/DataType";

const defaultProps = {
	draft: undefined,
	teams: undefined,
};

const propTypes = {
	draft: PropTypes.object,
	teams: PropTypes.arrayOf(PropTypes.object),
};

export default class DraftSequence extends React.Component {
	constructor(props) {
		super(props);

		this.columns = [
			new Column({title: '', field: 'orderNumber', sortOrder: ['orderNumber'], dataType: DataType.NUMBER}),
			new Column({title: 'Team', field: 'teamName', sortOrder: ['teamName', 'orderNumber'], dataType: DataType.STRING}),
			new Column({title: 'Position', field: 'playerPosition', sortOrder: ['playerPosition', 'orderNumber'], dataType: DataType.STRING}),
			new Column({title: 'Rating', field: 'playerRating', sortOrder: ['playerRating', 'orderNumber'], dataType: DataType.STRING}),
		];
	}

	render() {
		// convert sequence in to table data: {orderNumber, teamName, playerName, playerPosition, playerRating}
		const teamMap = this.props.teams && _.keyBy(this.props.teams, 'guid');
		const playerMap = this.props.teams && this.props.teams.reduce((playerGuidMap, team) => {
			team.players.forEach(player => playerGuidMap[player.guid] = player);
			return playerGuidMap;
		}, {});

		const displayData = this.props.draft ? this.props.draft.draftSequence.map((sequence, i) => {
			const player = sequence.playerPickedGuid && playerMap[sequence.playerPickedGuid];
			return {
				orderNumber: i,
				teamName: teamMap[sequence.teamGuid].name,
				playerPosition: player ? player.position : '',
				playerRating: player ? player.rating : '',
			};
		}) : [];

		return (
			<React.Fragment>
				<TableWrapper
					columns={this.columns}
					list={displayData}
					dataKeyField="orderNumber"
				/>
			</React.Fragment>
		);
	}
}


DraftSequence.propTypes = propTypes;
DraftSequence.defaultProps = defaultProps;
