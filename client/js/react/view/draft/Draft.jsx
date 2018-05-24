import React from "react";
import PropTypes from "prop-types";
import {MenuItem, SelectField} from "material-ui";
import DraftSequence from "./DraftSequence";
import clone from 'clone';
import PlayersTableByLineupType from "../../components/TeamTable/PlayersTableByLineupType";

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

		this.state = {
			showTeamGuid: 'draft',
			teams: undefined,
			draft: undefined,
		};
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

		const teamsList = clone(this.state.teams);
		teamsList && teamsList.sort((a, b) => (this.props.account && this.props.account.team.guid === a.guid) ? -1 : a.name.localeCompare(b.name));

		return (
			<React.Fragment>
				<div className="draft-container">
					<div className="draft-sequence">
						<DraftSequence draft={this.state.draft} teams={this.state.teams} />
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
						<PlayersTableByLineupType players={players} hideColumns={hideColumns} />
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
- progress through draft instead of all at once
 */


Draft.propTypes = propTypes;
Draft.defaultProps = defaultProps;
