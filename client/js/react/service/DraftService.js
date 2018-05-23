import BaseService from "./BaseService";

export default class extends BaseService {
	constructor(service) {
		super(service);

		this.getDraft = this.getDraft.bind(this);
	}

	getDraft(accountGuid, teamGuid, callback) {
		this.service.webservice.draftWebService.get(accountGuid, teamGuid, callback);
	}
};
