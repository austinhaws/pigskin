import React from "react";
import PropTypes from "prop-types";
import {Tab, Tabs} from "material-ui";
import Enum from '../../../enum/Enum.js';
import TableWrapper from "../../components/TableWrapper/TableWrapper";
import Column from "../../components/TableWrapper/Column";
import DataType from "../../components/TableWrapper/DataType";

const defaultProps = {
	account: undefined,
};

const propTypes = {
	account: PropTypes.object,
	service: PropTypes.object.isRequired,
};

const SortColumns = {
	COLUMN_NAME: 'name',
	COLUMN_POSITION: 'position',
	COLUMN_RATING: 'rating',
	COLUMN_AGE: 'age',
	COLUMN_PASS_SKILL: 'passSkill',
	COLUMN_RUN_SKILL: 'runSkill',
	COLUMN_KICK_SKILL: 'kickSkill',
	COLUMN_INJURY: 'injury',
};

export default class Team extends React.Component {
	constructor(props) {
		super(props);

		this.state = {
			sortColumn: SortColumns.COLUMN_NAME,
			sortDirection: 1,
			lineupType: Enum.positionType.OFFENSE,
		};

		this.tableColumns = [
			new Column({title: 'Name', field:'name', dataType: DataType.STRING, sortOrder:['name', 'position', 'rating']}),
			new Column({title: 'Position', field:'position', dataType: DataType.STRING, sortOrder:['position', 'name', 'rating']}),
			new Column({title: 'Rating', field:'rating', dataType: DataType.STRING, sortOrder:['rating', 'name', 'position']}),
			new Column({title: 'Age', field:'age', dataType: DataType.NUMBER, sortOrder:['age', 'name', 'position', 'rating']}),
			new Column({title: 'Pass', field:'passSkill', dataType: DataType.NUMBER, sortOrder:['passSkill', 'name', 'position', 'rating']}),
			new Column({title: 'Run', field:'runSkill', dataType: DataType.NUMBER, sortOrder:['runSkill', 'name', 'position', 'rating']}),
			new Column({title: 'Kick', field:'kickSkill', dataType: DataType.NUMBER, sortOrder:['kickSkill', 'name', 'position', 'rating']}),
			new Column({title: 'Injury', field:'injury', dataType: DataType.NUMBER, sortOrder:['injury', 'name', 'position', 'rating']}),
		]
	}

	render() {
		// sort the data every time because google material is stupid
		this.props.account && this.props.account.team.players.sort((a, b) => {
			let sortValue = this.props.service.sortService.sortAnything(a[this.state.sortColumn], b[this.state.sortColumn]);
			if (sortValue === 0) {
				sortValue = this.props.service.sortService.sortAnything(a[SortColumns.COLUMN_NAME], b[SortColumns.COLUMN_NAME]);
			}
			return sortValue * this.state.sortDirection;

		});
		const filterRoster = Enum.roster.rosterForPositionType(this.state.lineupType);
		const filteredPlayers = this.props.account ? this.props.account.team.players.filter(player => filterRoster.includes(player.position)) : [];
		return (
			<React.Fragment>
				<Tabs onChange={value => this.setState({lineupType: value})}>
					{Object.values(Enum.positionType).map(positionType => (
						<Tab key={positionType} label={positionType} selected={this.state.lineupType === positionType} value={positionType} />
					))}
				</Tabs>
				<TableWrapper
					columns={this.tableColumns}
					list={filteredPlayers}
					dataKeyField="guid"
				/>
			</React.Fragment>
		);
	}

}


Team.propTypes = propTypes;
Team.defaultProps = defaultProps;
