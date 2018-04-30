<?php

namespace App\WebAPI\Services;

use App\WebAPI\Dao\ChartDao;
use App\WebAPI\Enums\ChartType;

class ChartService extends BaseService
{
	/** @var ChartDao */
	private $chartDao;

	public function __construct($webApi)
	{
		parent::__construct($webApi);
		$this->chartDao = new ChartDao();
	}

	/**
	 * @param $position string Position enum
	 * @return string value of the randomly selected chart detail item
	 */
	public function playerUpgradeType($position) {
		$options = $this->chartDao->selectChartDetails(ChartType::PLAYER_UPGRADE_TYPE, $position);
		$option = $this->rollChart($options);
		return $option->value;
	}

	/**
	 * randomly select an option from weighted values
	 *
	 * @param $chartDetails \Illuminate\Support\Collection of chart_detail records
	 * @return object chart_detail record - randomly selected
	 */
	private function rollChart($chartDetails) {
		// sort by maximum ascending
		$chartDetailsSorted = $chartDetails->sort(function ($a, $b) {
			return $b->maximum - $a->maximum;
		});

		// get the maximum weight value
		$max = $chartDetailsSorted[0]->maximum;

		// roll a random weight value
		$roll = $this->webApi->rollService->roll(1, $max);
		$result = $chartDetailsSorted[0];
		// get the item that has the random weight value in its range
		for ($i = 0; $i < count($chartDetailsSorted) && $chartDetailsSorted[$i]->maximum >= $roll; $i++) {
			$result = $chartDetailsSorted[$i];
		}

		return $result;
	}

	/**
	 * randomly pick a rating
	 *
	 * @return string random rating
	 * @throws Exception
	 */
	public function randomRating() {
		throw new Exception('use a chart of odds of given ratings with A being rare and F common - use filter on chart for "draft"');
	}
}
