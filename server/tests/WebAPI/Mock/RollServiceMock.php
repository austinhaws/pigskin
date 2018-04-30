<?php

namespace App\WebAPI\Services\Mock;

use App\WebAPI\Services\RollService;

class RollServiceMock extends RollService
{
	/** @var array int the roll results to return */
	private $rollResults = [];

	/**
	 * generates a number
	 *
	 * @param $min int minimum value
	 * @param $max int maximum value
	 * @return int random number
	 */
	public function roll($min, $max) {
		if (!count($this->rollResults)) {
			throw new \RuntimeException('Out of test rolls! Call $this->>webApi->rollService->addRolls([3, 2, 1]); to add rolls for a test.');
		}
		return array_shift($this->rollResults);
	}

	/**
	 * @param $rolls array of int of the roll results to use
	 */
	public function setRolls($rolls) {
		$this->rollResults = $rolls;
	}
}
