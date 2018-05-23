import BaseWebservice from "./BaseWebservice";

// should only be imported by Webservice classes in the webservice "package" not by any outside pretenders
export default class extends BaseWebservice {
	constructor() {
		super();

		this.get = this.get.bind(this);
		this.pickPlayer = this.pickPlayer.bind(this);
	}

	/**
	 * get a draft
	 * @param accountGuid
	 * @param teamGuid
	 * @param callback
	 */
	get(accountGuid, teamGuid, callback) {
		this.webserviceCore.get(`draft/get/${accountGuid}/${teamGuid}`, undefined, callback);
	}

	/**
	 * pick a player from the draft
	 *
	 * @param accountGuid
	 * @param teamGuid
	 * @param playerGuid
	 * @param callback
	 */
	pickPlayer(accountGuid, teamGuid, playerGuid, callback) {
		this.webserviceCore.post(`draft/pick`, {accountGuid, teamGuid, playerGuid}, callback);
	}
};
