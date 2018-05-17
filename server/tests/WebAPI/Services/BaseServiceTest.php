<?php
namespace App\WebAPI\Test\Services;

use App\WebAPI\Test\Services\Utility\TypesCompare;
use App\WebAPI\Test\WebAPITest;
use PHPUnit\Framework\TestCase;

abstract class BaseServiceTest extends TestCase
{
	/** @var WebAPITest web api object loaded with a mock roller */
	protected $webApiTest;
	protected $typeCompare;

	public function __construct(?string $name = null, array $data = [], string $dataName = '')
	{
		parent::__construct($name, $data, $dataName);

		$this->webApiTest = new WebAPITest();
		$this->typeCompare = new TypesCompare();
	}

	/**
	 * clear rolls before each test
	 */
	protected function setUp() {
		$this->webApiTest->rollService->setRolls([]);
	}

	/**
	 * after each test, make sure rolls are all accounted for
	 */
	protected function tearDown() {
		$this->webApiTest->rollService->verifyRolls();
	}
}
