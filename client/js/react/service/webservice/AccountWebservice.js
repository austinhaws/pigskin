import BaseWebservice from "./BaseWebservice";

// should only be imported by Webservice classes in the webservice "package" not by any outside pretenders
export default class extends BaseWebservice {
	constructor(service) {
		super(service);

		this.create = this.create.bind(this);
		this.get = this.get.bind(this);
	}

	create(callback) {
		this.service.webserviceCore.get('account/create', undefined, callback)
	}

	get(accountKey, callback) {
		this.service.webserviceCore.get(`account/get/${accountKey}`, undefined, callback);
	}
};
