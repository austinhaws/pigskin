import React from "react";
import PropTypes from "prop-types";
import {Tab, Tabs} from "material-ui";
import DraftSequence from "./DraftSequence";
import TeamTableFilter from "../../components/TeamTable/TeamTableFilter";

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
			showTeamGuid: undefined,
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

		const showTeamGuid = this.state.showTeamGuid ? _.find(this.props.teams, team => team.guid === this.state.showTeamGuid) : undefined;
		const teamMap = _.keyBy(this.props.teams, 'guid');
		const showTeam = showTeamGuid ? teamMap[showTeamGuid] : (this.props.account ? this.props.account.team : undefined);

		return (
			<React.Fragment>
				<div className="draft-container">
					<div className="draft-sequence">
						<DraftSequence draft={this.state.draft} teams={this.state.teams} />
					</div>
					<div className="draft-teams">
						<Tabs onChange={teamGuid => this.setState({showTeamGuid: teamGuid})}>
							{this.props.teams ? this.props.teams.map(team => (
								<Tab key={team.name} label={team.name} selected={showTeamGuid === team.guid} value={team.guid} />
							)) : undefined}
						</Tabs>
						<TeamTableFilter team={showTeam}/>
					</div>

				</div>
			</React.Fragment>
		);
	}

}
/*

				left side is draft order with countdown and taken draft picks (name, position, rating)
				right side is teams view with tabs at top for Draft, MyTeamName, other teams...
				Can then switch between draft and team views

- menu at top to pick which team to view so can view what other teams have or go back to draft
	- if viewing a team, then the draft 1/2 page views go away and see just the team list (make team list component shareable with team page?)
	- when showing scores, if player doesn't have scores yet then put an "N/A" in the column as these will be determined after the draft
- 1/2 page width: draft picking sequence
	- teams in order of picks
	- if team has picked then show the name pos and rank of the player picked
- 1/2 page width: list of players (no scores nor injury)
	- columns
		- name
		- position
		- age
		- rating
		- star checkbox option icon image for remembering players
		- button to pick if it's your turn to pick
	- sortable
	- tabs for offense/defense/kick/starred
- timer runs in background and shows the next pick every few seconds until it is the player's turn and then the timer turns off and waits for the player to pick

 */


Draft.propTypes = propTypes;
Draft.defaultProps = defaultProps;
