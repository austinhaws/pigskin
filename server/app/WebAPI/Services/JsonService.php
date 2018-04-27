<?php

namespace App\WebAPI\Services;

class JsonService extends BaseService
{

	/**
	 * convert a json string of an array of objects into objects of the given class name
	 *
	 * @param $jsonString string json string of an array of objects
	 * @param $className string the classname to which to convert the objects
	 * @return array array of objects of the given class
	 */
	public function jsonToObjectArray($jsonString, $className) {
		return array_map(function ($jsonObj) use ($className) {
			return new $className($jsonObj);
		}, json_decode($jsonString));
	}
}
