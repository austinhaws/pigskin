import Webservice from './webservice/Webservice';
import LocalStorageService from "./LocalStorageService";
import ReduxService from "./ReduxService";
import AccountService from "./AccountService";
import SortService from "./SortService";
import DraftService from "./DraftService";

export default new class {

	constructor() {
		this.accountService = new AccountService(this);
		this.draftService = new DraftService(this);
		this.localStorageService = new LocalStorageService(this);
		this.reduxService = new ReduxService(this);
		this.sortService = new SortService(this);
		this.webservice = new Webservice(this);
	}
};
