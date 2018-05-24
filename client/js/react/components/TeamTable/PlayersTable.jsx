import React from "react";
import PropTypes from "prop-types";
import TableWrapper from "../../components/TableWrapper/TableWrapper";
import Column from "../../components/TableWrapper/Column";
import DataType from "../../components/TableWrapper/DataType";

const defaultProps = {
	players: undefined,
	hideColumns: [],
	addColumns: [],
};

const propTypes = {
	players: PropTypes.arrayOf(PropTypes.object),
	hideColumns: PropTypes.arrayOf(PropTypes.string),
	addColumns: PropTypes.arrayOf(PropTypes.instanceOf(Column)),
};

export default class PlayersTable extends React.Component {
	constructor(props) {
		super(props);

		this.tableColumns = [
			new Column({title: 'Name', field:'name', dataType: DataType.STRING, sortOrder:['name', 'position', 'rating']}),
			new Column({title: 'Position', field:'position', dataType: DataType.STRING, sortOrder:['position', 'name', 'rating']}),
			new Column({title: 'Rating', field:'rating', dataType: DataType.STRING, sortOrder:['rating', 'name', 'position']}),
			new Column({title: 'Age', field:'age', dataType: DataType.NUMBER, sortOrder:['age', 'name', 'position', 'rating']}),
			new Column({title: 'Pass', field:'passSkill', dataType: DataType.NUMBER, sortOrder:['passSkill', 'name', 'position', 'rating']}),
			new Column({title: 'Run', field:'runSkill', dataType: DataType.NUMBER, sortOrder:['runSkill', 'name', 'position', 'rating']}),
			new Column({title: 'Kick', field:'kickSkill', dataType: DataType.NUMBER, sortOrder:['kickSkill', 'name', 'position', 'rating']}),
			new Column({title: 'Injury', field:'injury', dataType: DataType.NUMBER, sortOrder:['injury', 'name', 'position', 'rating']}),
		];
	}

	render() {
		// sort the data every time because google material is stupid
		return (
			<TableWrapper
				columns={this.tableColumns.filter(c => !this.props.hideColumns.includes(c.field)).concat(this.props.addColumns)}
				list={this.props.players}
				dataKeyField="guid"
			/>
		);
	}

}

PlayersTable.propTypes = propTypes;
PlayersTable.defaultProps = defaultProps;
