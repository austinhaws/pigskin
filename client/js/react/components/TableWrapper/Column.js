import React from "react";
import DataType from "./DataType";

export default class {
	constructor({title, field, sortOrder, dataType, customSort}) {
		const requireField = (title, field) => field ? field : console.error(`{title} is required for a table's Column`);

		const requiredFields = [
			{field: 'title', title: 'title'},
			{field: 'field', title: 'field'},
			{field: 'dataType', title: 'dataType'},
			{field: 'sortOrder', title: 'sortOrder'},
		];

		if (dataType === DataType.CUSTOM) {
			requiredFields.push({field: 'customSort', title:'customSort'});
		}
		requiredFields.forEach(test => requireField(test.title, test.field));

		if (!Object.values(DataType).includes(dataType)) {
			console.error(`Invalid data type: {dataType}`);
		}

		this.title = title;
		this.field = field;
		this.sortOrder = sortOrder;
		this.dataType = dataType;
		this.customSort = customSort;
	}
};
