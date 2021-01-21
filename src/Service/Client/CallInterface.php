<?php

namespace ApiBuilder\Service\Client;

use ApiBuilder\DTO\ResponseDTO;

/**
 * Interface that needs to be implemented by any api call client
 */
interface CallInterface
{
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_GET = 'GET';
    const METHOD_DELETE = 'DELETE';

    /**
     * Adds header to be used in call
     *
     * @param string $headerName  Name of the header.
     * @param string $headerValue Value of the header.
     */
    public function addHeader(string $headerName, string $headerValue): void;

    /**
     * Adds curl option to be used with call
     *
     * @param string $curlOption CURL_OPT name.
     */
    public function setOption(string $curlOption, string $value): void;

    /**
     * If set to true, application/x-www-form-urlencoded will be used instead of json. Often required by authorize step in oAuth authentication
     *
     * @param bool $state CURL_OPT name.
     */
    public function setHttpEncodedPostParams(bool $state): void;

    /**
     * Method that holds logic for making api calls.
     *
     * @param string $method     Http method to be used for api call.
     * @param string $url        Url that call will be made to.
     * @param array  $parameters Parameters to be used on call. If empty no parameters will be used
     *
     * @return ResponseDTO Object tht holds response data form made call. Content, headers and info will be set
     */
    public function call(string $method, string $url, array $parameters = []): ResponseDTO;
}
