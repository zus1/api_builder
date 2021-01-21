<?php

namespace ApiBuilder\DTO;

use ApiBuilder\DTO\Package\ApiExceptionDTO;

class ResponseDTO
{
    private bool $exception = false;
    private ApiExceptionDTO $exceptionContent;
    private string $content = '';
    private array $info;
    private array $headers = [];
    private array $response;

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getInfo(): array
    {
        return $this->info;
    }

    public function setInfo(array $info): void
    {
        $this->info = $info;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    public function setResponse(array $response): void
    {
        $this->response = $response;
    }

    public function getResponse(): array
    {
        return $this->response;
    }

    public function isException(): bool
    {
        return $this->exception;
    }

    public function setException(bool $exception): void
    {
        $this->exception = $exception;
    }

    public function getExceptionContent(): ApiExceptionDTO
    {
        return $this->exceptionContent;
    }

    public function setExceptionContent(ApiExceptionDTO $exceptionContent): void
    {
        $this->exceptionContent = $exceptionContent;
    }
}
