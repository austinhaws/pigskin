import React from "react";
import {render} from "react-dom";
import {Provider} from "react-redux";
import redux from "../common/redux";
import {BrowserRouter, Route, Switch} from "react-router-dom";
import Admin from "../admin/Admin";
import Menu from "./Menu";
import Team from "../team/Team";

class Home extends React.Component {

	render() {
		return (
			<React.Fragment>
				<div id="title" className="chalk-font">Pig Skin</div>
				<div id="account-container">put me here{this.props.account ? this.props.account.phrase : ''}</div>
				<Menu {...this.props}/>
				<Switch>
					<Route path="/admin" render={() => <Admin {...this.props}/>}/>
					<Route path="/team" render={() => <Team {...this.props}/>}/>
					<Route render={() => <div>no matching route</div>}/>
				</Switch>
			</React.Fragment>
		);
	}

}

render(<BrowserRouter basename="/pigskin/client"><Provider store={redux}><Home/></Provider></BrowserRouter>, document.getElementById('app'));
