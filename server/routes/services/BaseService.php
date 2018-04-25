<?php

class BaseService
{
	protected $webApi;

	public function __construct($webApi)
	{
		$this->webApi = $webApi;
	}
}