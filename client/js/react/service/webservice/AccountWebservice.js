import BaseWebservice from "./BaseWebservice";

// should only be imported by Webservice classes in the webservice "package" not by any outside pretenders
export default class extends BaseWebservice {
	constructor() {
		super();

		this.create = this.create.bind(this);
		this.get = this.get.bind(this);
	}

	create(callback) {
		this.webserviceCore.get('account/create', undefined, callback)
	}

	get(accountKey, callback) {
		this.webserviceCore.get(`account/get/${accountKey}`, undefined, callback);
	}
};
