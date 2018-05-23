import BaseService from "../BaseService";
import AccountWebservice from "./AccountWebservice";
import DraftWebservice from "./DraftWebservice";

export default class extends BaseService {
	constructor(service) {
		super(service);

		this.accountWebservice = new AccountWebservice();
		this.draftWebService = new DraftWebservice();
	}
};
