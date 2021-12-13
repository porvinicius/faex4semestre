<?php

use App\Http\Router;

// Definir as Rotas

/** @var Router $router */
$router->get('/', [\App\Controllers\pages\HomeController::class, 'index'], 'home');

$router->get('/login', [\App\Controllers\pages\LoginController::class, 'index'], 'login', ['RequireUserLogout']);
$router->post('/login', [\App\Controllers\pages\LoginController::class, 'login'], 'login.do', ['RequireUserLogout']);

$router->get('/register', [\App\Controllers\pages\RegisterController::class, 'index'], 'register', ['RequireUserLogout']);
$router->post('/register', [\App\Controllers\pages\RegisterController::class, 'register'], 'register.do', ['RequireUserLogout']);

$router->get('/room/{id}', [\App\Controllers\pages\RoomController::class, 'index'], 'id.room');

$router->get('/reserves', [\App\Controllers\pages\ReservesController::class, 'index'], 'reserves', ['RequireUserLogin']);
$router->post('/reserves/room/{id}/add', [\App\Controllers\pages\ReservesController::class, 'create'], 'reserves.create', ['RequireUserLogin']);

$router->group('/adm', function($router) {
  $router->get('/', function() use ($router) {
    $router->redirect('adm');
  });

  $router->get('/reserves', [\App\Controllers\adm\ReserveController::class, 'index'], 'adm');
  $router->get('/reserve/{id}/remove', [\App\Controllers\adm\ReserveController::class, 'remove'], 'remove.do');

  $router->get('/checkin', [\App\Controllers\adm\CheckInController::class, 'index'], 'checkin');
  $router->get('/checkout', [\App\Controllers\adm\CheckOutController::class, 'index'], 'checkout');

  $router->get('/clientes', [\App\Controllers\adm\ClienteController::class, 'index'], 'client');

  $router->get('/rooms', [\App\Controllers\adm\RoomController::class, 'index'], 'rooms');
  $router->get('/rooms/add', [\App\Controllers\adm\RoomController::class, 'indexAdd'], 'rooms.add');
  $router->post('/rooms/add', [\App\Controllers\adm\RoomController::class, 'addRoom'], 'rooms.add.do');
  $router->put('/room/{id}/status', [\App\Controllers\adm\RoomController::class, 'chengeStatus'], 'room.chengestatus');
  $router->get('/room/{id}/remove', [\App\Controllers\adm\RoomController::class, 'destroy'], 'room.destroy');
  $router->get('/room/{id}/edit', [\App\Controllers\adm\RoomController::class, 'edit'], 'room.edit');
  $router->post('/rooms/{id}/edit', [\App\Controllers\adm\RoomController::class, 'editDo'], 'room.edit.do');

}, ['RequireRoleAdm']);

$router->get('/logout', [\App\Controllers\pages\LoginController::class, 'logout'], 'logout.do', ['RequireUserLogin']);
