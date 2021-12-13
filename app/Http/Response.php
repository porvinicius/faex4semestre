<?php


namespace App\Http;


class Response {

    protected int $httpCode = 200;
    protected array $headers = [];
    protected string $contentType = 'text/html';
    protected $content;

    public function __construct(int $httpCode, $content, string $contentType = 'text/html')
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
        $this->sendResponse();
    }

    /**
     * @param string $contentType
     */
    public function setContentType(string $contentType): void
    {
        $this->contentType = $contentType;
        $this->addHeaders('Content-type', $contentType);
    }

    public function addHeaders($key, $value): void
    {
        $this->headers[$key] = $value;
    }

    protected function sendHeaders(): void
    {
        http_response_code($this->httpCode);

        foreach ($this->headers as $key => $value) {
            header($key.': '.$value);
        }
    }

    public function sendResponse()
    {
        $this->sendHeaders();

        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
            case 'application/json':
              echo json_encode($this->content);
              exit;
        }
    }
}
