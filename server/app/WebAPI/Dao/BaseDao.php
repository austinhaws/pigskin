<?php

namespace App\WebAPI\Dao;

abstract class BaseDao
{
	/**
	 * remove fields from a copy of an array object; useful for taking out ID from an update object
	 *
	 * @param array $dbRecord the record to strip out fields (unchanged)
	 * @param array $removeFields the fields to remove
	 * @return array copy of $dbRecord without $removeFields
	 */
	protected function removeFields(array $dbRecord, array $removeFields = ['id'])
	{
		$copyArray = $dbRecord;
		foreach ($removeFields as $field) {
			unset($copyArray[$field]);
		}
		return $copyArray;
	}
}
