<?php

namespace App\WebAPI\Services;

use App\WebAPI\WebAPI;

class BaseService
{
	/** @var WebAPI all the Services available for your consumption, SIR! */
	protected $webApi;

	/**
	 * BaseService constructor.
	 * @param WebAPI $webApi
	 */
	public function __construct(WebAPI $webApi)
	{
		$this->webApi = $webApi;
	}

}