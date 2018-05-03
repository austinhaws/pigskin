import webserviceCore from "./WebserviceCore.js";

export default {
	account: {
		create: callback => webserviceCore.get('account/create', undefined, callback),
		get: (accountKey, callback) => webserviceCore.get(`account/get/${accountKey}`, undefined, callback),
	}
};
