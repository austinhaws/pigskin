import BaseService from "../BaseService";
import webserviceCore from "./WebserviceCore";

export default class extends BaseService {

	constructor(service) {
		super(service);

		this.webserviceCore = webserviceCore;
	}
};
