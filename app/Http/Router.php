<?php

namespace App\Http;

class Router extends Dispatch
{

  public function __construct(string $base_url, $group='', $middleware = [])
  {
    parent::__construct($base_url, $group, $middleware);
  }

  public function get($route, $callback, string $name = null, $middleware = []): void
  {
    $this->addRoute("GET", $route, $callback, $name, $middleware);
  }

  public function post($route, $callback, string $name = null, $middleware = []): void
  {
    $this->addRoute("POST", $route, $callback, $name, $middleware);
  }

  public function put($route, $callback, string $name = null, $middleware = []): void
  {
    $this->addRoute("PUT", $route, $callback, $name, $middleware);
  }

  public function patch($route, $callback, string $name = null, $middleware = []): void
  {
    $this->addRoute("PATCH", $route, $callback, $name, $middleware);
  }

  public function delete($route, $callback, string $name = null, $middleware = []): void
  {
    $this->addRoute("DELETE", $route, $callback, $name, $middleware);
  }

  public function group($groupName, $callback, $middleware = [])
  {
    $groupName = $this->group.$groupName;
    $this->groupRouter[] = new Router($this->baseUrl, $groupName, $middleware);
    return $callback(end($this->groupRouter));
  }
}