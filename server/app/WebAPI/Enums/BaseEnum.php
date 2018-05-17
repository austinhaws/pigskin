<?php

namespace App\WebAPI\Enums;

use ReflectionClass;

abstract class BaseEnum {

	/**
	 * oh no you don't
	 */
	private function constructor() {
		throw new \RuntimeException('Do not instantiate enumerations');
	}

	/**
	 * @return string the class of the child class so that constants can be pulled from it
	 */
	abstract static function who();

	static function getConstants() {
		try {
			return (new ReflectionClass(static::who()))->getConstants();
		} catch (\ReflectionException $e) {
			throw new \RuntimeException($e);
		}
	}
}
