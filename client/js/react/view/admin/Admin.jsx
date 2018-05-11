import React from "react";
import {Route, Switch} from "react-router-dom";
import TestRoutes from "./TestRoutes.jsx";

export default class Admin extends React.Component {

	constructor(props) {
		super(props);
		this.renderAdminMenu = this.renderAdminMenu.bind(this);
	}

	renderAdminMenu() {
		return (
			<ul>
				<li><a href="admin/testRoutes">Test Routes</a></li>
			</ul>
		);
	}

	render() {
		return (
			<Switch>
				<Route path="/admin/testRoutes" render={() => <TestRoutes {...this.props}/>}/>
				<Route render={this.renderAdminMenu}/>
			</Switch>
		);
	}
}
