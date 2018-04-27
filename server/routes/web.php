<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\WebAPI\WebAPI;

$webApi = new WebAPI();

$router->get('account/create', function () use ($webApi) {
	return $webApi->responseService->cleanJsonResponse($webApi->accountService->create());
});

$router->get('account/get/{phraseOrGuid}', function ($phraseOrGuid) use ($webApi) {
	return $webApi->responseService->cleanJsonResponse($webApi->accountService->get($phraseOrGuid));
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});
