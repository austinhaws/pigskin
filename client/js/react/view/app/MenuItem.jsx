import React from "react";
import PropTypes from "prop-types";
import {Link} from "react-router-dom";

const propTypes = {
	url: PropTypes.string.isRequired,
	title: PropTypes.string.isRequired,
};

export default class MenuItem extends React.Component {

	render() {
		return (
			<Link to={this.props.url} className="menu-item">
				<div className="menu-item-title">{this.props.title}</div>
			</Link>
		);
	}
}

MenuItem.propTypes = propTypes;
