<?php

namespace App\WebAPI\Services;

class BaseService
{
	/** @var WebAPI all the Services available for your consumption, SIR! */
	protected $webApi;

	public function __construct($webApi)
	{
		$this->webApi = $webApi;
	}
}