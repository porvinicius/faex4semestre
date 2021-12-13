<?php


namespace App\Http\Middleware;


use App\Http\Request;
use Closure;

interface Middleware
{
  public function handle(Request $request, Closure $next);
}