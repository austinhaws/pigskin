<?php

namespace App\WebAPI\Models;

abstract class BaseModel
{
	/** @var string all records have a guid for identification since these will be in json strings */
	public $guid;

	/**
	 * BaseModel constructor.
	 * given a json string, decode that to a plain object and then pull those fields in to the pojo
	 *
	 * @param $jsonString
	 */
	public function __construct($jsonString = '')
	{
		if ($jsonString) {
			$jsonObj = json_decode($jsonString);

			$fields = get_object_vars($this);
			foreach ($fields as $field => $fieldType) {
				$this->{$field} = $jsonObj[$field];
			}
		}
	}
}