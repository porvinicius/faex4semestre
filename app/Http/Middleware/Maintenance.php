<?php

namespace App\Http\Middleware;

use App\Http\Request;
use Closure;

class Maintenance implements Middleware
{
  public function handle(Request $request, Closure $next)
  {
    if(getenv('MAINTENANCE') == 'true') {
      print_r('Desculpe mas essa pagina esta em manutenção. tente novamente mais tarde.');
      exit;
    }
    return $next($request);
  }
}