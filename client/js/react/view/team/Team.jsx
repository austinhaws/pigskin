import React from "react";
import PropTypes from "prop-types";
import TeamTableFilter from "../../components/TeamTable/TeamTableFilter";

const defaultProps = {
	account: undefined,
};

const propTypes = {
	account: PropTypes.object,
};

export default class Team extends React.Component {
	render() {
		return <TeamTableFilter team={this.props.account ? this.props.account.team : undefined} />;
	}

}

Team.propTypes = propTypes;
Team.defaultProps = defaultProps;
