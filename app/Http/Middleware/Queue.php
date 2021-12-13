<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Http\Response;

class Queue
{
  protected static array $map = [];

  protected static array $default = [];

  protected array $middlewares = [];

  protected $controller;

  protected $action;

  protected array $controllerArgs = [];

  public function __construct(array $middlewares, $controller, $args = [], $action = null)
  {
    $this->middlewares = array_merge(self::$default, $middlewares);
    $this->controller = $controller;
    $this->controllerArgs = $args;
    $this->action = $action;
  }

  public function next(Request $request)
  {
    if(empty($this->middlewares) && empty($this->action)) return call_user_func_array($this->controller, $this->controllerArgs);
    if(empty($this->middlewares) && !empty($this->action)) return call_user_func_array(array($this->controller, $this->action), $this->controllerArgs);

    $middleware = array_shift($this->middlewares);

    if (empty(self::$map[$middleware])) {
      throw new \Exception("O middleware não pode ser processado.", 500);
    }

    $queue = $this;

    $next = function ($request) use ($queue) {
      return $queue->next($request);
    };

    return (new self::$map[$middleware])->handle($request, $next);
  }

  /**
   * @param array $default
   */
  public static function setDefault(array $default): void
  {
    self::$default = $default;
  }

  /**
   * @param array $map
   */
  public static function setMap(array $map): void
  {
    self::$map = $map;
  }
}