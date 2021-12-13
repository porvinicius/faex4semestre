<?php

namespace App\Http;

class Request {
  protected string $uri;
  protected Dispatch $router;
  protected string $httpMethod;
  protected array $queryParams;
  protected array $postVars;
  protected array $headers;

  public function __construct(Dispatch $router)
  {
    $this->setUri();
    $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
    $this->router = $router;
    $this->queryParams = $_GET ?? [];
    $this->postVars = $_POST ?? [];
    $this->headers = getallheaders() ?? [];
  }


  /**
   * @return Router
   */
  public function getRouter(): Dispatch
  {
    return $this->router;
  }

  public function setUri()
  {
    $this->uri = $_SERVER['REQUEST_URI'] ?? '';
    $xUri = explode('?', $this->uri);
    $uri = $xUri[0];
    $base = explode('/', BASE_URL);
    unset($base[0]);
    unset($base[2]);
    $base = implode('/', $base);
    $this->uri = str_replace($base, '', $uri);
  }




  /**
   * @return array|false
   */
  public function getHeaders()
  {
    return $this->headers;
  }

  /**
   * @return array
   */
  public function getPostVars(): array
  {
    return $this->postVars;
  }

  /**
   * @return array
   */
  public function getQueryParams(): array
  {
    return $this->queryParams;
  }

  /**
   * @return mixed|string
   */
  public function getUri(): string
  {
    return $this->uri;
  }

  /**
   * @return mixed|string
   */
  public function getHttpMethod(): string
  {
    return $this->httpMethod;
  }

}