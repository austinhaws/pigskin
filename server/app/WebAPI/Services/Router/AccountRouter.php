<?php

namespace App\WebAPI\Services\Router;

class AccountRouter extends BaseRouter
{

	/**
	 * @param \Laravel\Lumen\Routing\Router $router
	 */
	function init($router)
	{
		$that = $this;
		$router->get('account/create', function () use(&$that) {return $that->accountCreate();});
		$router->get('account/get/{phraseOrGuid}', function ($phraseOrGuid) use(&$that) {return $that->accountGet($phraseOrGuid);});
	}

	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function accountCreate() {
		return $this->webApi->responseService->cleanJsonResponse($this->webApi->accountService->create());
	}

	/**
	 * @param $phraseOrGuid string
	 * @return \Illuminate\Http\JsonResponse
	 */
	function accountGet($phraseOrGuid) {
		return $this->webApi->responseService->cleanJsonResponse($this->webApi->accountService->get($phraseOrGuid));
	}
}