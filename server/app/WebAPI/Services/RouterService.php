<?php

namespace App\WebAPI\Services;

use App\WebAPI\Services\Router\AccountRouter;
use App\WebAPI\Services\Router\BaseRouter;
use App\WebAPI\Services\Router\DraftRouter;
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
			new DraftRouter($webApi),
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
