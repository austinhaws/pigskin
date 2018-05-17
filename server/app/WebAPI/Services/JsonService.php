<?php

namespace App\WebAPI\Services;

class JsonService extends BaseService
{

	/**
	 * convert a json string of an array of objects into objects of the given class name
	 *
	 * @param $jsonString string json string of an array of objects
	 * @param $class string fully qualified name of the class (ie MyClass::class)
	 * @return array array of objects of the given class
	 */
	public function jsonToObjectArray($jsonString, $class)
	{
		return array_map(function ($jsonObj) use ($class) {
			return new $class(json_encode($jsonObj));
		}, json_decode($jsonString));
	}

	/**
	 * convert all fields in an object from snake case to camel case.
	 * This is helpful for when objects come from the database and go out through json to javascript.
	 *
	 * @param $obj object same object with field names changed
	 * @return object the SAME object with snake case changed to camelcase
	 */
	public function snakeCaseToCamelCase(&$obj)
	{
		foreach (get_object_vars($obj) as $field => $value) {
			$camelField = $this->dashesToCamelCase($field);
			if ($camelField !== $field) {
				$obj->{$camelField} = $value;
				unset($obj->{$field});
			}
		}
		return $obj;
	}

	/**
	 * https://stackoverflow.com/questions/2791998/convert-dashes-to-camelcase-in-php
	 *
	 * @param $string string to try to convert to camel from dashed
	 * @param bool $capitalizeFirstCharacter should first character of the whole word be capitalized?
	 * @return string
	 */
	private function dashesToCamelCase($string, $capitalizeFirstCharacter = false)
	{
		$str = str_replace('_', '', ucwords($string, '_'));

		if ($capitalizeFirstCharacter) {
			$str = ucfirst($str);
		} else {
			$str = lcfirst($str);
		}

		return $str;
	}
}
