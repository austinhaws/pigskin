import BaseService from "./BaseService";

export default class extends BaseService {

	constructor(service) {
		super(service);

		this.getItem = this.getItem.bind(this);
		this.setItem = this.setItem.bind(this);
	}

	/**
	 * get a value out of localStorage
	 * @param key string key for the item
	 * @return {string | null}
	 */
	getItem(key) {
		return localStorage.getItem(key);
	}

	/**
	 * set a value in to localStorage
	 * @param key string key for the item
	 * @param value string value for the item
	 */
	setItem(key, value) {
		localStorage.setItem(key, value);
	}
};
