import BaseService from "./BaseService";

export default class extends BaseService {
	constructor(service) {
		super(service);

		this.getCurrent = this.getCurrent.bind(this);
		this.storeAccount = this.storeAccount.bind(this);

		this.localStorageAccountKey = 'accountPhrase';
	}

	/**
	 * get the current account by first checking if localstorage has an account key and if not then
	 * creating a new account
	 */
	getCurrent() {
		// check if localStorage holds current account guid
		const accountPhrase = this.service.localStorageService.getItem(this.localStorageAccountKey);

		if (accountPhrase) {
			// fetch the account connected to the guid
			this.service.webservice.accountWebservice.get(accountPhrase, this.storeAccount)
		} else {
			// if not then create new account to get guid
			this.service.webservice.accountWebservice.create(this.storeAccount)
		}
	}

	/**
	 * update redux with the account
	 *
	 * @param account
	 */
	storeAccount(account) {
		this.service.reduxService.dispatchObjectAtPath(false, 'account', account);
	}
};
