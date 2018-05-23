<?php
namespace App\WebAPI\Test\Services;

use App\WebAPI\Test\WebAPITest;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Laravel\Lumen\Testing\TestCase;

abstract class BaseServiceTest extends TestCase
{
	/** @var WebAPITest web api object loaded with a mock roller */
	protected $webApiTest;

	use DatabaseTransactions;

	public function __construct(?string $name = null, array $data = [], string $dataName = '')
	{
		parent::__construct($name, $data, $dataName);

		$this->webApiTest = new WebAPITest();
	}

	/**
	 * Creates the application.
	 *
	 * Needs to be implemented by subclasses.
	 *
	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		return require __DIR__ . '/../../../bootstrap/app.php';

	}

	/**
	 * clear rolls before each test
	 */
	public function setUp() {
		parent::setup();
		$this->webApiTest->rollService->setRolls([]);
	}

	/**
	 * after each test, make sure rolls are all accounted for
	 */
	public function tearDown() {
		parent::tearDown();
		$this->webApiTest->rollService->verifyRolls();
	}
}
