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
			throw new \RuntimeException('Out of test rolls! Call $this->webApi->rollService->setRolls([3, 2, 1]); to add rolls for a test.');
		}
		$roll = array_shift($this->rollResults);
		if ($roll === '*') {
			$this->rollResults[] = $roll;
			$roll = parent::roll($min, $max);
		}
		return $roll;
	}

	/**
	 * @param $rolls array of int of the roll results to use
	 */
	public function setRolls($rolls) {
		$this->rollResults = $rolls;
	}

	/**
	 * make sure rolls were all usd
	 */
	public function verifyRolls() {
		$numRolls = count($this->rollResults);
		if ($numRolls > 1 || ($numRolls === 1 && $this->rollResults[0] !== '*')) {
			throw new \RuntimeException('There are rolls remaining: ' . json_encode($this->rollResults));
		}
	}
}
