import React from "react";
import PropTypes from "prop-types";
import Column from "./Column";
import {Table, TableBody, TableHeader, TableHeaderColumn, TableRow, TableRowColumn} from "material-ui";
import clone from 'clone';
import _ from 'lodash';
import DataType from "./DataType";

const defaultProps = {
	onCellClick: undefined,
};

const propTypes = {
	// the columns to show in the table
	columns: PropTypes.arrayOf(PropTypes.instanceOf(Column)).isRequired,

	// the list of objects of data to show in the table
	list: PropTypes.arrayOf(PropTypes.object).isRequired,

	// which data field identifies this record
	dataKeyField: PropTypes.string.isRequired,

	// a cell was clicked
	onCellClick: PropTypes.func,
};

export default class TableWrapper extends React.Component {
	constructor(props) {
		super(props);

		this.onHeaderClick = this.onHeaderClick.bind(this);

		this.state = {
			sortColumn: this.props.columns[0],
			sortDirection: 1,
		};
	}

	onHeaderClick(proxy, row, col) {
		const newColumn = this.props.columns[col - 1];

		if (this.state.sortColumn === newColumn) {
			this.setState({
				sortDirection: this.state.sortDirection * -1,
			});
		} else {
			this.setState({
				sortColumn: newColumn,
				sortDirection: 1,
			});
		}
	}

	sortData() {
		const columnMap = _.keyBy(this.props.columns, 'field');
		const sortOrder = this.state.sortColumn.sortOrder;
		const showList = clone(this.props.list);
		showList.sort((a, b) => {
			return sortOrder.reduce((result, field) => {
				if (result === 0) {
					const column = columnMap[field];
					switch (column.dataType) {
						case DataType.STRING:
							result = _.toString(a[column.field]).localeCompare(_.toString(b[column.field]));
							break;
						case DataType.NUMBER:
							result = _.toNumber(a[column.field]) - _.toNumber(b[column.field]);
							break;
						case DataType.CUSTOM:
							result = column.customSort(a, b);
							break;
						default:
							console.error(`Invalid column dataType: {column.dataType}`);
							break;
					}
				}
				return result;
			}, 0) * this.state.sortDirection;
		});
		return showList;
	}

	render() {
		// sort every time in case data changed
		const showList = this.sortData();

		return (
			<Table
				className="table"
				fixedHeader={false}
				onCellClick={this.props.onCellClick}
			>
				<TableHeader displaySelectAll={false} adjustForCheckbox={false}>
					<TableRow onCellClick={this.onHeaderClick}>
						{this.props.columns.map(c => <TableHeaderColumn key={c.title}>{c.title}</TableHeaderColumn>)}
					</TableRow>
				</TableHeader>

				<TableBody displayRowCheckbox={false}>
					{
						showList.map(data => (
							<TableRow key={data[this.props.dataKeyField]}>
								{this.props.columns.map(c => c.customRowColumn ? c.customRowColumn(data) : <TableRowColumn key={c.field}>{data[c.field]}</TableRowColumn>)}
							</TableRow>
						))
					}
				</TableBody>
			</Table>
		);
	}
};

TableWrapper.defaultProps = defaultProps;
TableWrapper.propTypes = propTypes;
