import React from "react";
import PropTypes from "prop-types";

const defaultProps = {
	account: undefined,
};

const propTypes = {
	account: PropTypes.object,
	service: PropTypes.object.isRequired,
};

export default class Team extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		return <div>Show me some team stuff</div>;
	}

}


Team.propTypes = propTypes;
Team.defaultProps = defaultProps;
