import React from "react";
import PropTypes from "prop-types";
import PlayersTableByLineupType from "../../components/TeamTable/PlayersTableByLineupType";

const defaultProps = {
	account: undefined,
};

const propTypes = {
	account: PropTypes.object,
};

export default class Team extends React.Component {
	render() {
		return <PlayersTableByLineupType players={this.props.account ? this.props.account.team.players : undefined} />;
	}

}

Team.propTypes = propTypes;
Team.defaultProps = defaultProps;
