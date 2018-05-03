import React from "react";
import webservice from "../webservice/webservice";

export default class TestRoutes extends React.Component {

	constructor(props) {
		super(props);

		this.state = {
			accountId: '',
			callOutput: '',
		};

		this.callCreateAccount = this.callCreateAccount.bind(this);
		this.changeAccountId = this.changeAccountId.bind(this);
		this.callGetAccount = this.callGetAccount.bind(this);
		this.callbackToOutput = this.callbackToOutput.bind(this);
	}

	callCreateAccount() {
		webservice.account.create(this.callbackToOutput);
	}

	changeAccountId(e) {
		this.setState({accountId: e.target.value});
	}

	callGetAccount() {
		webservice.account.get(this.state.accountId, this.callbackToOutput);
	}

	callbackToOutput(data) {
		this.setState({callOutput: JSON.stringify(data)});
	}

	render() {
		return (
			<React.Fragment>
				<div className="subtitle">Test Web Service Routes</div>
				<ul>
					<li>
						<button onClick={this.callCreateAccount}>Create Account</button>
					</li>
					<li>
						<input type="text" onChange={this.changeAccountId} value={this.state.accountId}/> <button onClick={this.callGetAccount}>Get Account</button>
					</li>
				</ul>
				<textarea value={this.state.callOutput} style={{width: '100%', height: '500px'}}/>
			</React.Fragment>
		);
	}
}
