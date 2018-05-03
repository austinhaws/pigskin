import axios from "axios";

export default new class {
	constructor() {
		this.baseUrl = '/pigskin/server/public/';
	}

	callCallback(callback) {
		return result => callback(result.data);
	}

	post(url, data, callback) {
		axios
			.post(this.baseUrl + url, data)
			.then(this.callCallback(callback))
			.catch(this.error);
	}

	error(error) {
		console.error(error);
	}

	get(url, data, callback) {
		axios
			.get(this.baseUrl + url, data)
			.then(this.callCallback(callback))
			.catch(this.error);
	}
};
