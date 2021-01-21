<?php

namespace ApiBuilder\Service\Client;

use ApiBuilder\DTO\ResponseDTO;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class GuzzleClient implements CallInterface
{
    private array $headers = [];
    private array $defaultHeaders = [
        'Content-Type' => 'application/json',
    ];
    private array $defaultOptions = [
        CURLOPT_FORBID_REUSE => 0,
    ];
    private array $options = [];
    private bool $httpEncodedPostParams = false;
    private array $allowedMethods = [self::METHOD_GET, self::METHOD_POST, self::METHOD_PUT, self::METHOD_DELETE];

    public function addHeader(string $headerName, string $headerValue): void
    {
        $this->headers[$headerName] = $headerValue;
    }

    public function setOption(string $curlOption, string $value): void
    {
        $this->options[$curlOption] = $value;
    }

    public function setHttpEncodedPostParams(bool $state): void
    {
        $this->httpEncodedPostParams = $state;
    }

    public function call(string $method, string $url, array $parameters = []): ResponseDTO
    {
        $method = strtoupper($method);
        if (!in_array($method, $this->allowedMethods)) {
            throw new \Exception('Invalid method');
        }
        //dd($url);
        $options = $this->handleOptions($method, $parameters);

        $options['headers'] = $this->defaultHeaders + $this->headers;
        $options['curl'] = $this->defaultOptions + $this->options;

        $client = new Client(['http_errors' => false]);
        $response = $client->request($method, $url, $options);

        return $this->makeResponse($response);
    }

    private function makeResponse(ResponseInterface $response): ResponseDTO
    {
        $dto = new ResponseDTO();
        $dto->setContent($response->getBody()->getContents());
        $dto->setHeaders($response->getHeaders());
        $dto->setInfo($this->formatResponseInfo($response));

        return $dto;
    }

    private function formatResponseInfo(ResponseInterface $response): array
    {
        return [
            'http_code' => $response->getStatusCode(),
            'status' => $response->getReasonPhrase(),
            'protocol' => $response->getProtocolVersion(),
        ];
    }

    private function handleOptions(string $method, array $parameters): array
    {
        $options = [];
        if (!empty($parameters)) {
            if ($method === self::METHOD_GET) {
                $this->handleGetOptions($parameters, $options);
            } elseif ($method === self::METHOD_POST) {
                $this->handlePostOptions($parameters, $options);
            } elseif ($method === self::METHOD_PUT) {
                $this->handlePutOptions($parameters, $options);
            } elseif ($method === self::METHOD_DELETE) {
                if (!empty($parameters)) {
                    trigger_error('Parameters should not be used for delete request', E_USER_WARNING);
                }
            }
        }

        $options['headers'] = $this->headers;
        $options['curl'] = $this->defaultOptions + $this->options;

        return $options;
    }

    private function handleGetOptions(array $parameters, array &$options): void
    {
        $options['query'] = $parameters;
    }

    private function handlePostOptions(array $parameters, array &$options): void
    {
        if ($this->httpEncodedPostParams === true) {
            $options['form_params'] = $parameters;
            $this->headers['Content-Type'] = 'application/x-www-form-urlencoded';
        } else {
            $options['body'] = json_encode($parameters, JSON_UNESCAPED_UNICODE);
        }
    }

    private function handlePutOptions(array $parameters, array &$options): void
    {
        $this->handlePostOptions($parameters, $options);
    }
}
