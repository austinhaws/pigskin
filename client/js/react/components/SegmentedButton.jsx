import React from "react";
import PropTypes from "prop-types";
import _ from "lodash";
import {FlatButton} from "material-ui";

const propTypes = {
	value: PropTypes.oneOfType([
		// single select
		PropTypes.string,
		// multi select
		PropTypes.arrayOf(PropTypes.string),
	]).isRequired,

	// what function to trigger when a change is detected (could be a dispatcher);
	// parameters: value
	onChange: PropTypes.func,

	// the options to show as buttons to select from
	options: PropTypes.arrayOf(PropTypes.string).isRequired,

	// should allow multiple selections? value comes in as array and goes out as array
	multiSelect: PropTypes.bool,
};

const defaultProps = {
	onChange: undefined,
	size: '',
	className: undefined,
	multiSelect: false,
};

export default class SegmentedButton extends React.Component {
	constructor(props) {
		super(props);
		this.onButtonPress = this.onButtonPress.bind(this);
	}

	onButtonPress(newValue) {
		let useValue = newValue;
		if (this.props.multiSelect) {
			if (this.props.value.includes(useValue)) {
				useValue = this.props.value.filter(v => v !== useValue);
			} else {
				useValue = this.props.value.concat([useValue]);
			}
		}
		this.props.onChange && this.props.onChange(useValue);
	}

	render() {
		const valuesArray = _.castArray(this.props.value);
		return (
			<div id={this.props.field} className="segmented-button-wrapper">
				{this.props.options.map(option => {
					const selected = valuesArray.includes(option);
					return (
						<FlatButton
							key={option}
							primary={selected}
							secondary={!selected}
							value={option}
							onClick={() => this.onButtonPress(option)}
						>{option}</FlatButton>
					);
				})}
			</div>
		);
	}
}

SegmentedButton.propTypes = propTypes;
SegmentedButton.defaultProps = defaultProps;
