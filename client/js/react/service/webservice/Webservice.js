import BaseService from "../BaseService";
import AccountWebservice from "./AccountWebservice";

export default class extends BaseService {
	constructor(service) {
		super(service);

		this.accountService = new AccountWebservice(service);
	}
};
