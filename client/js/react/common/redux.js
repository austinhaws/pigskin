import React from "react";
import {createStore} from "redux";
import _ from "lodash";
import clone from "clone";

function objectAtPath(obj, path) {
	return path
		.split('\.')
		.reduce((prevObj, piece) => prevObj[piece], obj);
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
	//result[action.payload.path][action.payload.field] = action.payload.value;
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
	}
);
