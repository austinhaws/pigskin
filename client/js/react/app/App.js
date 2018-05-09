import React from "react";
import {render} from "react-dom";
import {connect, Provider} from "react-redux";
import redux from "../common/redux";
import {BrowserRouter, Route, Switch, withRouter} from "react-router-dom";
import Admin from "../admin/Admin";
import Menu from "./Menu";
import Team from "../team/Team";
import service from "../service/Service";

class App extends React.Component {

	constructor(props) {
		super(props);

		this.service = service;

		// localstorage and ajax to get account, and store in redux which will trigger rerender (wow...)
		this.service.accountService.getCurrent();
	}

	render() {
		const comboProps = Object.assign({}, this.props, {service: this.service});

		return (
			<React.Fragment>
				<div id="title" className="chalk-font">Pig Skin</div>
				<div id="account-container">{this.props.account ? this.props.account.phrase : ''}</div>
				<Menu {...this.props}/>
				<Switch>
					<Route path="/admin" render={() => <Admin {...comboProps}/>}/>
					<Route path="/team" render={() => <Team {...comboProps}/>}/>
					<Route render={() => <div>no matching route</div>}/>
				</Switch>
			</React.Fragment>
		);
	}

}

const AppConnected = withRouter(connect(state => state, {})(App));
render(<BrowserRouter basename="/pigskin/client"><Provider store={redux}><AppConnected/></Provider></BrowserRouter>, document.getElementById('app'));
