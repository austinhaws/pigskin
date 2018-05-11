import React from "react";
import {render} from "react-dom";
import {connect, Provider} from "react-redux";
import redux from "../../common/redux";
import {BrowserRouter, Route, Switch, withRouter} from "react-router-dom";
import Admin from "../admin/Admin.jsx";
import Menu from "./Menu.jsx";
import Team from "../team/Team.jsx";
import service from "../../service/Service";
import {MuiThemeProvider} from "material-ui";

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
			<MuiThemeProvider>
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
			</MuiThemeProvider>
		);
	}

}

const AppConnected = withRouter(connect(state => state, {})(App));
render(<BrowserRouter basename="/pigskin/client"><Provider store={redux}><AppConnected/></Provider></BrowserRouter>, document.getElementById('app'));
