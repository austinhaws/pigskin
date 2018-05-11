import React from "react";
import PropTypes from "prop-types";
import {Tab, Table, TableBody, TableHeader, TableHeaderColumn, TableRow, TableRowColumn, Tabs} from "material-ui";
import Enum from '../../../enum/Enum.js';

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

		this.onTeamCellClick = this.onTeamCellClick.bind(this);
		this.onTeamHeaderClick = this.onTeamHeaderClick.bind(this);
	}

	onTeamCellClick() {
		console.log(arguments);
	}

	onTeamHeaderClick(proxy, row, col) {
		const column = SortColumns[Object.keys(SortColumns)[col - 1]];
		if (this.state.sortColumn === column) {
			this.setState({
				sortDirection: this.state.sortDirection * -1,
			});
		} else {
			this.setState({
				sortColumn: column,
				sortDirection: 1,
			});
		}
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
				<Table
					className="team-table"
					fixedHeader={false}
					onCellClick={this.onTeamCellClick}
				>
					<TableHeader displaySelectAll={false} adjustForCheckbox={false}>
						<TableRow onCellClick={this.onTeamHeaderClick}>
							<TableHeaderColumn >Name</TableHeaderColumn>
							<TableHeaderColumn>Position</TableHeaderColumn>
							<TableHeaderColumn>Rating</TableHeaderColumn>
							<TableHeaderColumn>Age</TableHeaderColumn>
							<TableHeaderColumn>Pass</TableHeaderColumn>
							<TableHeaderColumn>Run</TableHeaderColumn>
							<TableHeaderColumn>Kick</TableHeaderColumn>
							<TableHeaderColumn>Injury</TableHeaderColumn>
						</TableRow>
					</TableHeader>
					<TableBody displayRowCheckbox={false}>
					{
						filteredPlayers.map(player => (
							<TableRow key={player.guid}>
								<TableRowColumn>{player.name}</TableRowColumn>
								<TableRowColumn>{player.position}</TableRowColumn>
								<TableRowColumn>{player.rating}</TableRowColumn>
								<TableRowColumn>{player.age}</TableRowColumn>
								<TableRowColumn>{player.passSkill}</TableRowColumn>
								<TableRowColumn>{player.runSkill}</TableRowColumn>
								<TableRowColumn>{player.kickSkill}</TableRowColumn>
								<TableRowColumn>{player.injury}</TableRowColumn>
							</TableRow>
						))
					}
					</TableBody>
				</Table>
			</React.Fragment>
		);
	}

}


Team.propTypes = propTypes;
Team.defaultProps = defaultProps;
