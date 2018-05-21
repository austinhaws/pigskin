<?php

namespace App\WebAPI\Dao;

use App\WebAPI\Enums\DBTable;
use Illuminate\Support\Facades\DB;

class ChartDao extends BaseDao
{
	/**
	 * @param $chartType string ChartType...
	 * @param null $filter string chart detail filter
	 * @return \Illuminate\Support\Collection
	 */
	public function selectChartDetails($chartType, $filter = null) {
		$query = DB::table(DBTable::CHART_DETAIL)->where('chartId', DB::raw("(SELECT id FROM chart WHERE name = '$chartType')"));

		if ($filter) {
			$query = $query->where('filter', $filter);
		}

		return $query->get();
	}
}