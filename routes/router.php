<?php

use App\Http\Router;

$router = new Router(BASE_URL);

require 'web.php';

$router->get('/error/{errorCode}', [\App\Controllers\pages\ErrorController::class, 'index'], 'error');

$router->dispatch();

$err = $router->getError();

if (isset($err)) {
    $router->redirect('error', [ 'errorCode' => $err ]);
}