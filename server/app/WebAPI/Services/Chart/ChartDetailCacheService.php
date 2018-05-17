<?php

namespace App\WebAPI\Services\Chart;

class ChartDetailCacheService
{
	/** @var array chartType => filter => ChartDetail[] */
	private $chartDetailCache;

	public function __construct()
	{
		$this->chartDetailCache = [];
	}

	/**
	 * get a set of chart details from the cache
	 *
	 * @param $chartType string ChartType... the chart looked up
	 * @param $filter string the filter used for the query
	 * @return \Illuminate\Support\Collection|false list of chart detail objects or false if not found
	 */
	public function getCacheDetail($chartType, $filter) {
		$useFilter = $this->cleanFilter($filter);
		return isset($this->chartDetailCache[$chartType][$useFilter]) ? $this->chartDetailCache[$chartType][$useFilter] : false;
	}

	/**
	 * @param $chartType string ChartType... the chart looked up
	 * @param $filter string the filter used for the query
	 * @param $details \Illuminate\Support\Collection the details to put in the cache
	 */
	public function setCacheDetail($chartType, $filter, $details) {
		$this->chartDetailCache[$chartType][$this->cleanFilter($filter)] = $details;
	}

	/**
	 * if filter is null or falsey, make it an empty string so that it can be a key in the cache
	 *
	 * @param $filter string
	 * @return string has to be a non-null string
	 */
	private function cleanFilter($filter) {
		return $filter ? $filter : '';
	}
}
