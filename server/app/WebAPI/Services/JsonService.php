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
}
