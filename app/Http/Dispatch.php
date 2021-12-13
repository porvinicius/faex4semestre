<?php

namespace App\Http;

use App\Http\Middleware\Queue;
use ReflectionClass;
use ReflectionFunction;

class Dispatch
{
  use RouterTrait;

  protected string $uri = '';
  protected string $baseUrl;
  protected string $prefix = '';
  protected static array $routes = [];
  protected array $groupRouter;
  protected $route;
  protected string $group = '';
  protected Request $request;
  protected $error;
  protected array $middleware = [];

  public const BAD_REQUEST = 400;
  public const NOT_FOUND = 404;
  public const METHOD_NOT_ALLOWED = 405;
  public const NOT_IMPLEMENTED = 501;

  public function __construct(string $base_url, $group = '', $middleware = [])
  {
    $this->baseUrl =(substr($base_url, "-1") == "/" ? substr($base_url, 0, -1) : $base_url);
    $this->request = new Request($this);
    $this->group = $group ?? '';
    $this->middleware = $middleware;
    $this->setPrefix();
  }

  public function dispatch(): bool
  {

    if (empty(self::$routes)) {
      $this->error = self::NOT_IMPLEMENTED;
      return false;
    }

    $this->route = null;
    foreach (self::$routes[$this->request->getHttpMethod()] as $key => $route) {
      if (preg_match("~^" . $key . "$~", $this->getUri(), $found)) {
        $this->route = $route;
      }
    }
    return $this->execute();
  }

    private function execute(): bool
  {

    if ($this->route) {
      if (is_callable($this->route['handler'])) {
        $reflection = new ReflectionFunction($this->route['handler']);
        foreach ($reflection->getParameters() as $params) {
          $name = $params->getName();
          $args[] = $this->route['data'][$name];
        }

        (new Queue($this->route['middleware'], $this->route['handler'], $args ?? []))->next($this->request);
//        call_user_func_array($this->route['handler'], ($args ?? []));
        return true;
      }
      $controller = $this->route['handler'];
      $method = $this->route['action'];

      if (class_exists($controller)) {
        $newController = new $controller();
        if (method_exists($controller, $method)) {
          $reflection = new ReflectionClass($this->route['handler']);
          foreach ($reflection->getMethod($this->route['action'])->getParameters() as $params) {
            $name = $params->getName();
            $args[] = $this->route['data'][$name];
          }
          (new Queue($this->route['middleware'], $newController, $args ?? [], $method))->next($this->request);
//          call_user_func_array(array($newController, $method), ($args ?? []));
          return true;
        }
        $this->error = self::METHOD_NOT_ALLOWED;
        return false;
      }
      $this->error = self::BAD_REQUEST;
      return false;
    }
    $this->error = self::NOT_FOUND;
    return false;
  }

  public function getError()
  {
    return $this->error;
  }
}