<?php

namespace App\WebAPI\Dao;

use App\WebAPI\Enums\DBTable;
use Illuminate\Support\Facades\DB;

class ChartDao
{
	public function selectChartDetails($chartType, $filter = null) {
		$query = DB::table(DBTable::CHART_DETAIL)->where('chart_id', DB::raw("(SELECT id FROM chart WHERE name = '$chartType')"));

		if ($filter) {
			$query = $query->where('filter', $filter);
		}

		return $query->get();
	}
}