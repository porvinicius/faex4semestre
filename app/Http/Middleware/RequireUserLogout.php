<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Session\User\Login as LoginSession;
use Closure;

class RequireUserLogout implements Middleware
{
  public function handle(Request $request,Closure $next)
  {
    if (LoginSession::isLogged()) {
      $request->getRouter()->redirect('home');
    }

    return $next($request);
  }
}