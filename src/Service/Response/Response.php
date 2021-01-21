<?php

namespace ApiBuilder\Service\Response;

use ApiBuilder\DTO\Package\ApiExceptionDTO;
use ApiBuilder\DTO\ResponseDTO;

class Response implements ResponseInterface
{
    private array $nonErrorCodes = [200, 204, 302];
    private bool $nonJson = false;

    public function setNonJsonResponse(bool $state): void
    {
        $this->nonJson = $state;
    }

    public function handleException(ApiExceptionDTO $apiExceptionDTO, int $httpCode, string $message = ''): void
    {
        $apiExceptionDTO->setCode($httpCode);
        if ($message !== '') {
            $apiExceptionDTO->setMessage($message);
        }
    }

    public function processResponse(ResponseDTO $responseDto): ResponseDTO
    {
        $info = $responseDto->getInfo();
        if (!in_array($info['http_code'], $this->nonErrorCodes)) {
            $responseDto->setException(true);

            $exceptionDTO = new ApiExceptionDTO();
            $this->handleException($exceptionDTO, $info['http_code']);

            $responseDto->setExceptionContent($exceptionDTO);
            $responseDto->setResponse(['error' => 1, 'http_code' => $info['http_code']]);

            return $responseDto;
        }

        if ($this->nonJson === true) {
            $responseDto->setResponse(['response' => $responseDto->getContent()]);
        } else {
            $responseDto->setResponse(json_decode($responseDto->getContent(), true));
        }

        return $responseDto;
    }
}
