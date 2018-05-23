import axios from "axios";

// not a service, but a utility class, so don't inherit from BaseService
// do not import this unless you are a webservice service
export default new class {
	constructor() {
		// get from index.html so that it can be changed on the fly without webpack when deployed
		this.baseUrl = globals.baseUrl;
	}

	// == Ajax calls == //
	post(url, data, callback) {
		axios
			.post(this.baseUrl + url, data)
			.then(this.callCallback(callback))
			.catch(this.error);
	}

	get(url, data, callback) {
		axios
			.get(this.baseUrl + url, data)
			.then(this.callCallback(callback))
			.catch(this.error);
	}

	// == Utility == //
	error(error) {
		console.error(error);
	}

	callCallback(callback) {
		return result => callback(result.data);
	}

};
