<?php

use App\Http\Middleware\Queue;


Queue::setMap([
  'maintenance' => \App\Http\Middleware\Maintenance::class,
  'RequireUserLogin' => \App\Http\Middleware\RequireUserLogin::class,
  'RequireUserLogout' => \App\Http\Middleware\RequireUserLogout::class,
  'RequireRoleAdm' => \App\Http\Middleware\RequireRoleAdm::class
]);

Queue::setDefault([
  'maintenance'
]);