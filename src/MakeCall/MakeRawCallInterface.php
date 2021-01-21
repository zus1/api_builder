<?php

namespace ApiBuilder\MakeCall;

use ApiBuilder\DTO\ResponseDTO;
use ApiBuilder\Service\Client\CallInterface;
use ApiBuilder\Service\Response\ResponseInterface;

interface MakeRawCallInterface
{
    /**
     * Use this method to make call to api.
     *
     * @param array         $parameters Parameters to be used with api call
     * @param CallInterface $call       Call client to be used for interacting with api.
     *
     * @return ResponseDTO Object that holds response data form api call. Holds content, response headers and info
     */
    public function makeCall(array $parameters, CallInterface $call): ResponseDTO;

    /**
     * Use this method to make call to api.
     *
     * @param ResponseDTO       $responseDTO Object that holds response data form made api call
     * @param ResponseInterface $response    Object that will be used to process response data.
     *
     * @return ResponseDTO After processing addition fields could be set on response object: response, exception, ApiExceptionDTO exception content
     */
    public function processResponse(ResponseDTO $responseDTO, ResponseInterface $response): ResponseDTO;
}
