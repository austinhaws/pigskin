import React from "react";
import PropTypes from "prop-types";
import {Table, TableBody, TableHeader, TableHeaderColumn, TableRow, TableRowColumn} from "material-ui";

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
	COLUMN_SPECIAL_SKILL: 'specialSkill',
	COLUMN_INJURY: 'injury',
};

export default class Team extends React.Component {
	constructor(props) {
		super(props);

		this.state = {
			sortColumn: SortColumns.COLUMN_NAME,
			sortDirection: 1,
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

		return (
			<React.Fragment>
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
							<TableHeaderColumn>Special</TableHeaderColumn>
							<TableHeaderColumn>Injury</TableHeaderColumn>
						</TableRow>
					</TableHeader>
					<TableBody displayRowCheckbox={false}>
					{
						this.props.account ? this.props.account.team.players.map(player => (
							<TableRow key={player.guid}>
								<TableRowColumn>{player.name}</TableRowColumn>
								<TableRowColumn>{player.position}</TableRowColumn>
								<TableRowColumn>{player.rating}</TableRowColumn>
								<TableRowColumn>{player.age}</TableRowColumn>
								<TableRowColumn>{player.passSkill}</TableRowColumn>
								<TableRowColumn>{player.runSkill}</TableRowColumn>
								<TableRowColumn>{player.specialSkill}</TableRowColumn>
								<TableRowColumn>{player.injury}</TableRowColumn>
							</TableRow>
						)) : undefined
					}
					</TableBody>
				</Table>
			</React.Fragment>
		);
	}

}


Team.propTypes = propTypes;
Team.defaultProps = defaultProps;
