<?php

namespace ApiBuilder\MakeCall\Google\Books;

use ApiBuilder\Base\Google\BaseBooks;
use ApiBuilder\DTO\ResponseDTO;
use ApiBuilder\MakeCall\MakeRawCallInterface;
use ApiBuilder\Service\Client\CallInterface;
use ApiBuilder\Service\Response\ResponseInterface;

class BooksByTitleCall extends BaseBooks implements MakeRawCallInterface
{
    public function makeCall(array $parameters, CallInterface $call): ResponseDTO
    {
        return $this->booksCallWithQueryKey($call, CallInterface::METHOD_GET, 'volumes', $parameters);
    }

    public function processResponse(ResponseDTO $responseDTO, ResponseInterface $response): ResponseDTO
    {
        return $response->processResponse($responseDTO);
    }
}
