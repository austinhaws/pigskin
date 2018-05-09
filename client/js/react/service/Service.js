import Webservice from './webservice/Webservice';
import redux from "../common/redux";

export default new class {

	constructor() {
		this.webservice = new Webservice(this);
		this.redux = redux;
	}
};
