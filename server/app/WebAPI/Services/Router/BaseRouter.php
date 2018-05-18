<?php

namespace App\WebAPI\Services\Router;

use App\WebAPI\Services\BaseService;
use Laravel\Lumen\Routing\Router;

abstract class BaseRouter extends BaseService {

	/**
	 * @param $router Router
	 */
	abstract public function init($router);
}
