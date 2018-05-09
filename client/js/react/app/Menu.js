import React from "react";
import MenuItem from "./MenuItem";

export default class Menu extends React.Component {

	render() {
		return (
			<ul className="main-menu">
				<MenuItem url="/" title="Home" {...this.props}/>
				<MenuItem url="/team" title="Team" {...this.props}/>
				<MenuItem url="/draft" title="Draft" {...this.props}/>
			</ul>
		);
	}

}
