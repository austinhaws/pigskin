<?php

namespace App\WebAPI\Services\Router;

use App\WebAPI\Test\Services\BaseServiceTest;

abstract class BaseRouterTest extends BaseServiceTest
{
	/**
	 * @param object $response
	 * @return object json decoded object
	 */
	protected function decodeJsonFromResponse($response) {
		return json_decode($response->response->content());
	}
}
