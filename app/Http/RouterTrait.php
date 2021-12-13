<?php


namespace App\Http;

trait RouterTrait
{

  protected $data;

  protected function addRoute(string $method, string $route, $callback, string $name = null, $middleware = []): void
  {
    if ($route == "/") {
      $this->addRoute($method, "", $callback, $name, $middleware);
    }

    $route = $this->group.$route;

    preg_match_all("~\{\s* ([a-zA-Z_][a-zA-Z0-9_-]*) \}~x", $route, $keys, PREG_SET_ORDER);
    $routeDiff = array_values(array_diff(explode("/", $this->request->getUri()), explode("/", $route)));
    $offset = 0;
    $this->data = null;
    foreach ($keys as $key) {
      $this->data[$key[1]] = ($routeDiff[$offset++] ?? null);
      $offset++;
    }

    $data = $this->data;

    $data['request'] = $this->request;

    $middleware = array_merge($middleware, $this->middleware);

    $router = function() use ($method, $route, $callback, $data, $name, $middleware) {
      return [
        'name' => $name,
        'route' => $route,
        'method' => $method,
        'handler' => $this->getHandler($callback),
        'action' => $this->getAction($callback),
        'data' => $data,
        'middleware' => $middleware
      ];
    };

    $route = preg_replace('~{([^}]*)}~', "([^/]+)", $route);

    self::$routes[$method][$route] = $router();
  }

  public function getHandler($callback)
  {
    if (!is_array($callback)) {
      return $callback;
    }

    return $callback[0];
  }

  public function getAction($callback)
  {
    if (!is_array($callback)) {
      return false;
    }

    return $callback[1];
  }

  private function getUri()
  {
    $uri = $this->request->getUri();

    $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

    return end($xUri);
  }

  private function setPrefix(): void
  {
    $urlParse = parse_url($this->baseUrl);

    $this->prefix = $urlParse['path'] ?? '';

  }

  public function redirect($route, $data=null): void
  {

    if ($name = $this->route($route, $data)) {
      header("Location: {$name}");
      exit;
    }

    if (filter_var($route, FILTER_VALIDATE_URL)) {
      header("Location: {$route}");
      exit;
    }

    $route = (substr($route, 0, 1) == '/' ? $route : "/{$route}");
    header("Location: {$this->baseUrl}{$route}");
    exit;
  }

  public function route(string $name, array $data = null): ?string
  {
    foreach (self::$routes as $http_verb) {
      foreach ($http_verb as $route_item) {
        if (!empty($route_item['name']) && $route_item['name'] == $name) {
          return $this->treat($route_item, $data);
        }
      }
    }
    return null;
  }

  public function treat($route_item, $data): ?string
  {
    $route = $route_item['route'] === '' ? '/' : $route_item['route'];
    if (!empty($data)) {
      $args = [];
      $param = [];
      foreach($data as $key => $value) {
        if (!strstr($route, "{{$key}}")) {
          $param[$key] = $value;
        }
        $args["{{$key}}"] = $value;
      }
      $route = $this->process($route, $args, $param);
    }
    return "{$this->baseUrl}{$route}";
  }

  public function process($route, $args, $param): string
  {
    $param = (!empty($param) ? "?".http_build_query($param) : null);
    return str_replace(array_keys($args), array_values($args), $route)."${param}";
  }
}