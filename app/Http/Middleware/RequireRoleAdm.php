<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Session\User\Login;
use Closure;

class RequireRoleAdm implements Middleware
{

  public function handle(Request $request, Closure $next)
  {
    if (Login::role() !== 'ADM') {
      $request->getRouter()->redirect('home');
    }

    return $next($request);
  }
}