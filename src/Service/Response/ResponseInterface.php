<?php

namespace ApiBuilder\Service\Response;

use ApiBuilder\DTO\Package\ApiExceptionDTO;
use ApiBuilder\DTO\ResponseDTO;

/**
 * Interface that needs to be implemented by any response processor
 */
interface ResponseInterface
{
    /**
     * Method for processing api call responses.
     *
     * @param ResponseDTO $responseDto Object that holds response data form api call. Additional fields will be set depending on response data
     *
     * @return ResponseDTO Object with (possibly) additional fields set: response, exception, ApiExceptionDTO exception content
     */
    public function processResponse(ResponseDTO $responseDto): ResponseDTO;

    /**
     * Api call exception handler.
     *
     * @param ApiExceptionDTO $apiExceptionDTO If exception occurred, this dto will be  returned as a packageDTO
     * @param int             $httpCode        Response code received by api. Needs to be set on $apiExceptionDTO
     * @param string          $message         Optional, can be set here if clear message received from api
     */
    public function handleException(ApiExceptionDTO $apiExceptionDTO, int $httpCode, string $message = ''): void;

    /**
     * Use this method to indicate that non json response is being processed. Response will be treated as simple string
     *
     * @param bool $state Toggles json response on or off
     */
    public function setNonJsonResponse(bool $state): void;
}
