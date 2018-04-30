<?php

use App\WebAPI\Services\Mock\RollServiceMock;
use App\WebAPI\WebAPI;

abstract class BaseServiceTest extends TestCase
{
	/** @var WebAPI web api object loaded with a mock roller */
	protected $webApi;

	public function __construct(?string $name = null, array $data = [], string $dataName = '')
	{
		parent::__construct($name, $data, $dataName);

		$this->webApi = new WebAPI();
		$rollServiceMock = new RollServiceMock($this->webApi);
		$this->webApi->rollService = $rollServiceMock;
	}
}
