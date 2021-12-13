<?php

namespace App\Http\Middleware;

use App\Session\User\Login as LoginSession;

class RequireUserLogin implements Middleware
{
  public function handle($request, $next)
  {
    if (!LoginSession::isLogged()) {
      $request->getRouter()->redirect('login');
    }

    return $next($request);
  }
}