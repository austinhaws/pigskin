import React from "react";
import {render} from "react-dom";
import {Provider} from "react-redux";
import redux from "../common/redux";
import {BrowserRouter, Route, Switch} from "react-router-dom";

// ==== setup react container for the report ==== //
class Home extends React.Component {

	render() {
		return (
			<React.Fragment>
				<div id="title" className="chalk-font">Pig Skin</div>
				<Switch>
					<Route path="/admin" render={() => <div>admin</div>}/>
					<Route render={() => <div>Let me test your stuff</div>}/>
				</Switch>
			</React.Fragment>
		);
	}

}

render(<BrowserRouter basename="/pigskin/client"><Provider store={redux}><Home/></Provider></BrowserRouter>, document.getElementById('app'));