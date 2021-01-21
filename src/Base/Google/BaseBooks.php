<?php

namespace ApiBuilder\Base\Google;


use ApiBuilder\DTO\ResponseDTO;
use ApiBuilder\Service\Client\CallInterface;

abstract class BaseBooks
{
    protected string $baseUrl = 'https://www.googleapis.com/books/v1';
    private string $googleApiKey = "AIzaSyCX8TFdu6ykaYi2JDUsQAxlNo0NNYQrquI";

    protected function booksCallWithQueryKey(CallInterface $call, string $method, string $endpoint, array $parameters = []): ResponseDTO
    {
        $url = $this->addEndpoint($endpoint);
        $parameters = $this->addApiKeyToQueryString($parameters);

        return $call->call($method, $url, $parameters);
    }

    protected function booksCallWithHeaderKey(CallInterface $call, string $method, string $endpoint, array $parameters = []): ResponseDTO
    {
        $url = $this->addEndpoint($endpoint);
        $this->addApiKeyToHeader($call);

        return $call->call($method, $url, $parameters);
    }

    private function addApiKeyToQueryString(array $parameters): array
    {
        $parameters['key'] = $this->googleApiKey;

        return $parameters;
    }

    private function addApiKeyToHeader(CallInterface $call): void
    {
        $call->addHeader('Authorization', $this->googleApiKey);
    }

    private function addEndpoint(string $endpoint): string
    {
        return sprintf('%s/%s', $this->baseUrl, $endpoint);
    }
}
