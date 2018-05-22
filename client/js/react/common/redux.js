import React from "react";
import {createStore} from "redux";
import _ from "lodash";
import clone from "clone";

// use ReduxService instead of calling or importing this stuff directly
function objectAtPath(baseObject, path) {
	return (path || '').split('\.').reduce((obj, field) => field ? obj[field] : obj, baseObject);
}

const reducers = {
	ACTION_TYPES: {
		OBJECT_PATH: 'OBJECT_PATH',
	},
};

reducers[reducers.ACTION_TYPES.OBJECT_PATH] = (state, action) => {
	const result = clone(state);
	// payload can be an array of targets or a single one
	_.castArray(action.payload).forEach(payload => objectAtPath(result, payload.path)[payload.field] = clone(payload.value));
	return result;

};

export {reducers};

// the store to connect all components to their data
export default createStore((state, action) => {
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
		ajaxCount: 0,
		account: undefined,
	}, window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__()
);
