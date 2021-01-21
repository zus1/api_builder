<?php

namespace ApiBuilder\Service\Client;

use ApiBuilder\DTO\ResponseDTO;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Call implements CallInterface
{
    const DEFAULT_TIMEOUT = 60;

    private HttpClientInterface $client;

    private array $headers = [];
    private array $defaultHeaders = [
        'Content-Type' => 'application/json',
    ];

    private array $defaultOptions = [
        CURLOPT_FORBID_REUSE => 0,
    ];

    private bool $httpEncoded = false;

    private array $options = [];
    private array $allowedMethods = [self::METHOD_PUT, self::METHOD_POST, self::METHOD_GET, self::METHOD_DELETE];

    public function addHeader(string $headerName, string $headerValue): void
    {
        $this->headers[$headerName] = $headerValue;
    }

    public function setOption(string $curlOption, string $value): void
    {
        $this->options[$curlOption] = $value;
    }

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /*
    * Default is json
    */
    public function setHttpEncodedPostParams(bool $state): void
    {
        $this->httpEncoded = $state;
    }

    public function call(string $method, string $url, array $parameters = []): ResponseDTO
    {
        if (!in_array($method, $this->allowedMethods)) {
            throw new \Exception('Invalid method');
        }
        //dd($url);
        $options = $this->handleOptions($method, $parameters);
        $response = $this->client->request($method, $url, $options);

        $dto = new ResponseDTO();
        try {
            $dto->setContent($response->getContent());
            $dto->setHeaders($response->getHeaders());
        } catch (\Exception $e) {
            //do nothing here, just prevent exception form being thrown
        }

        $dto->setInfo($response->getInfo());

        return $dto;
    }

    private function handleOptions(string $method, array $parameters): array
    {
        $options = [];
        if (!empty($parameters)) {
            if ($method === self::METHOD_GET) {
                $this->formatGetRequest($options, $parameters);
            } elseif ($method === self::METHOD_POST) {
                $this->formatPostRequest($options, $parameters);
            } elseif ($method === self::METHOD_PUT) {
                $this->formatPutRequest($options, $parameters);
            }
        }

        $curlOptions = $this->defaultOptions + $this->options;
        $options['extra']['curl'] = $curlOptions;
        $options['headers'] = $this->defaultHeaders + $this->headers;
        //dd($options);
        return $options;
    }

    private function formatGetRequest(array &$options, array $parameters): void
    {
        $options['query'] = $parameters;
    }

    private function formatPostRequest(array &$options, array $parameters): void
    {
        if ($this->httpEncoded === true) {
            $options['body'] = $parameters;
        } else {
            $options['body'] = json_encode($parameters, JSON_UNESCAPED_UNICODE);
        }
    }

    private function formatPutRequest(array &$options, array $parameters): void
    {
        $this->formatPostRequest($options, $parameters);
    }
}
