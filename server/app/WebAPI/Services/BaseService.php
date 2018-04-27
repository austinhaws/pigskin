<?php

namespace App\WebAPI\Services;

use App\WebAPI\WebAPI;

class BaseService
{
	/** @var WebAPI all the Services available for your consumption, SIR! */
	protected $webApi;

	public function __construct($webApi)
	{
		$this->webApi = $webApi;
	}
}