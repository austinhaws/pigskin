import BaseService from "./BaseService";

export default class extends BaseService {
	constructor(service) {
		super(service);
	}


	/**
	 * sorts two things that have the same type
	 *
	 * @param a * something
	 * @param b * something else
	 */
	sortAnything(a, b) {
		let result = a === b ? 0 : false;

		if (result !== 0) {
			if (typeof a === 'string') {
				result = a.localeCompare(b);
			} else {
				result = a - b;
			}
		}

		return result;
	}

	/**
	 * update redux with the account
	 *
	 * @param account
	 */
	storeAccount(account) {
		this.service.localStorageService.setItem(this.localStorageAccountKey, account.phrase);
		this.service.reduxService.dispatchObjectAtPath(false, 'account', account);
	}
};
