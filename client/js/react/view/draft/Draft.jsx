import React from "react";
import PropTypes from "prop-types";
import {MenuItem, SelectField, TableRowColumn} from "material-ui";
import DraftSequence from "./DraftSequence";
import clone from 'clone';
import PlayersTableByLineupType from "../../components/TeamTable/PlayersTableByLineupType";
import Column from "../../components/TableWrapper/Column";
import DataType from "../../components/TableWrapper/DataType";

const defaultProps = {
	account: undefined,
};

const propTypes = {
	account: PropTypes.object,
	service: PropTypes.object.isRequired,
};


export default class Draft extends React.Component {
	constructor(props) {
		super(props);

		this.draftSequenceInterval = this.draftSequenceInterval.bind(this);

		this.state = {
			showTeamGuid: 'draft',
			teams: undefined,
			draft: undefined,
			draftSequenceIndex: -1,
			draftSequenceTimer: undefined,
		};
	}

	componentDidMount() {
		if (!this.state.draftSequenceTimer) {
			this.setState({draftSequnceTimer: setInterval(this.draftSequenceInterval, 2500)})
		}
	}

	draftSequenceInterval() {
		if (this.state.draft) {
			// find max draft sequence that has been picked so far
			const maxPickedIndex = this.state.draft.draftSequence.reduce((maxPickedIndex, draftSequence, i) => Math.max(maxPickedIndex, draftSequence.playerPickedGuid ? i : -1), -1);

			// up draftSequenceIndex by 1 if the next pick has been picked or if it is the logged in player's turn
			if (this.state.draftSequenceIndex <= maxPickedIndex || (
				this.state.draft.draftSequence.length > this.state.draftSequenceIndex + 1 &&
				this.props.account &&
				this.state.draft.draftSequence[this.state.draftSequenceIndex + 1].teamGuid === this.props.account.team.guid
			)) {
				this.setState({draftSequenceIndex: this.state.draftSequenceIndex + 1});
			}
		}
	}

	componentWillReceiveProps(nextProps) {
		if (!this.props.account && nextProps.account && nextProps.account.guid) {
			// yay! we have an account, ajax for the draft information
			this.props.service.draftService.getDraft(nextProps.account.guid, nextProps.account.team.guid, draftInfo => this.setState({teams: draftInfo.teams, draft: draftInfo.draft}));
		}
	}

	render() {

		let showTeam = (this.state.showTeamGuid && this.state.showTeamGuid !== 'draft') ? _.find(this.state.teams, team => team.guid === this.state.showTeamGuid) : undefined;
		if (this.state.draft && this.state.showTeamGuid === 'draft') {
			showTeam = this.state.draft.availablePlayers;
		}

		let hideColumns;
		let players;
		if (this.state.draft && this.state.showTeamGuid === 'draft') {
			hideColumns = ['injury', 'passSkill', 'runSkill', 'kickSkill'];
			players = this.state.draft.availablePlayers;
		} else if (showTeam) {
			hideColumns = ['injury'];
			players=showTeam.players;
		}

		// if it's the player's turn to pick then show pick column buttons
		let addColumns;
		if (this.props.account && this.state.draft && this.state.draftSequenceIndex >= 0) {
			const draftSequence = this.state.draft.draftSequence[this.state.draftSequenceIndex];
			if (!draftSequence.playerPickedGuid && draftSequence.teamGuid === this.props.account.team.guid) {
				addColumns = [
					new Column({
						title: '',
						field: 'pickButton',
						sortOrder: ['name'],
						dataType:DataType.CUSTOM,
						customSort: (a, b) => a.name.localeCompare(b.name),
						customRowColumn: record => <TableRowColumn key={record.guid}>Hello World</TableRowColumn>}),
				];
			}
		}

		const teamsList = clone(this.state.teams);
		teamsList && teamsList.sort((a, b) => (this.props.account && this.props.account.team.guid === a.guid) ? -1 : a.name.localeCompare(b.name));

		return (
			<React.Fragment>
				<div className="draft-container">
					<div className="draft-sequence">
						<DraftSequence draft={this.state.draft} teams={this.state.teams} currentlyPickingIndex={this.state.draftSequenceIndex}/>
					</div>
					<div className="draft-teams">
						<SelectField value={this.state.showTeamGuid} onChange={(_, __, teamGuid) => this.setState({showTeamGuid: teamGuid})}>
							<MenuItem key="draft" value="draft" primaryText="Draft" />
							{teamsList ? teamsList.map((team, i) => (
								<MenuItem
									key={team.name}
									value={team.guid}
									primaryText={team.name}
									style={i === 1 ? {fontWeight: 'bold'} : {}}
								/>
							)) : undefined}
						</SelectField>
						<PlayersTableByLineupType players={players} hideColumns={hideColumns} addColumns={addColumns}/>
					</div>

				</div>
			</React.Fragment>
		);
	}

}
/*
- 1/2 page width: list of players (no scores nor injury)
	- columns
		- button to pick if it's your turn to pick
		- pass extra columns to playertablebylineup and have TableWrapper able to accept extra columns
		- the extra column for buttons has a custom columnRender that will create its own buttons
- progress through draft instead of all at once
 */


Draft.propTypes = propTypes;
Draft.defaultProps = defaultProps;
