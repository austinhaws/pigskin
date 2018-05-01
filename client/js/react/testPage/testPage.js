import React from "react";
import {render} from "react-dom";
import {Provider} from "react-redux";
import {createStore} from "redux";

// ==== setup react container for the report ==== //
class TestPage extends React.Component {

	render() {
		return <div>Let me test your stuff</div>;
	}

}

const reducers = {

};

// the store to connect all components to their data
const reduxStore = createStore((state, action) => {
		// === reducers ===
		let reducer = false;

		// is reducer valid?
		if (action.type in reducers) {
			reducer = reducers[action.type];
		}

		// ignore redux/react "system" reducers
		if (!reducer && action.type.indexOf('@@') !== 0) {
			console.error('unknown reducer action:', action.type, action)
		}

		// DO IT!
		return reducer ? reducer(state, action) : state;
	}, {
		// === default data ===
	}
);

render(<Provider store={reduxStore}><TestPage/></Provider>, document.getElementById('app'));
