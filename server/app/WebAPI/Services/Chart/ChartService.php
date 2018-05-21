<?php

namespace App\WebAPI\Services\Chart;

use App\WebAPI\Dao\Daos;
use App\WebAPI\Enums\ChartType;
use App\WebAPI\Services\BaseDaoService;
use App\WebAPI\WebAPI;

class ChartService extends BaseDaoService
{
	/** @var array chartType => filter => ChartDetail[] */
	private $chartDetailCache;

	public function __construct(WebAPI $webApi, Daos $daos)
	{
		parent::__construct($webApi, $daos);
		$this->chartDetailCache = new ChartDetailCacheService();
	}

	/**
	 * @param $position string Position enum
	 * @return string value of the randomly selected chart detail item
	 */
	public function playerUpgradeType($position) {
		return $this->rollDetailChart(ChartType::PLAYER_UPGRADE_TYPE, $position);
	}

	/**
	 * @return string age for the player
	 */
	public function playerAge() {
		return $this->rollDetailChart(ChartType::PLAYER_STARTING_AGE);
	}

	/**
	 * randomly select an option from weighted values
	 *
	 * @param $chartDetails \Illuminate\Support\Collection of chart_detail records
	 * @return object chart_detail record - randomly selected
	 */
	private function rollChart($chartDetails) {
		// sort by maximum ascending
		$chartDetailsSorted = $chartDetails->all();
		usort($chartDetailsSorted, function ($a, $b) {
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

	/**
	 * get chart details and return a randomly selected detail value
	 *
	 * @param $chartType string which chart ChartType... enum
	 * @param $filter string used to filter chart details from a chart type
	 * @return string the random value
	 */
	private function rollDetailChart($chartType, $filter = null)
	{
		$options = $this->chartDetailCache->getCacheDetail($chartType, $filter);
		if (!$options) {
			$options = $this->daos->chart->selectChartDetails($chartType, $filter);
			$this->chartDetailCache->setCacheDetail($chartType, $filter, $options);
		}

		return $this->rollChart($options)->value;
	}

	/**
	 * a chart has a value based on a filter, return that single value
	 *
	 * @param $chartType string which chart ChartType... enum
	 * @param $filter string used to filter chart details from a chart type
	 * @return string the matching value for the filter
	 */
	public function lookupChartValue($chartType, $filter) {
		return $this->rollDetailChart($chartType, $filter);
	}

	/**
	 * determine random rating for a tier level
	 *
	 * @param $tier int tier of ratings
	 * @return string Rating... A-F
	 */
	public function rollUpgradeRating($tier) {
		return $this->rollDetailChart(ChartType::UPGRADE_RATING, $tier);
	}
}
