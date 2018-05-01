<?php

namespace App\WebAPI\Test;

use App\WebAPI\Services\Mock\RollServiceMock;
use App\WebAPI\WebAPI;

class WebAPITest extends WebAPI
{
	/** @var RollServiceMock mocked roll service (overrides parent roll service) */
	public $rollService;

	public function __construct()
	{
		parent::__construct();

		$this->rollService = new RollServiceMock($this);
	}
}
