<?php

namespace App\WebAPI\Services\Router;

use App\WebAPI\Services\BaseService;
use Laravel\Lumen\Routing\Router;

class RouterService extends BaseService
{
	/** @var BaseRouter[] the routes to setup */
	private $routers;
	/** @var Router */
	private $router;

	public function __construct($webApi)
	{
		parent::__construct($webApi);
		$this->routers = [
			new AccountRouter($webApi),
		];
	}

	/**
	 * @param $router Router
	 */
	public function init($router)
	{
		$this->router = $router;

		foreach ($this->routers as $singleRouter) {
			$singleRouter->init($router);
		}
		$that = $this;
		$router->get('/', function () use(&$that) {return $that->version();});
	}

	public function version() {
		return $this->router->app->version();
	}
}
