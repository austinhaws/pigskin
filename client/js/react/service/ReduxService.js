import BaseService from "./BaseService";
import redux, {reducers} from "../common/redux";

export default class extends BaseService {
	constructor(service) {
		super(service);

		this.dispatchObjectAtPath = this.dispatchObjectAtPath.bind(this);
	}

	/**
	 * common object at path dispatcher
	 *
	 * @param path string path to object in dot notation (ie. parent.object.path.to.child)
	 * @param field string the field in the object to set
	 * @param value * the new value of the field in the object
	 */
	dispatchObjectAtPath(path, field, value) {
		redux.dispatch({type: reducers.ACTION_TYPES.OBJECT_PATH, payload: {path: path, field: field, value: value}});
	}
};
