<?php

namespace ApiBuilder;

use ApiBuilder\DTO\Package\RawDataDto;
use ApiBuilder\DTO\ResponseDTO;
use ApiBuilder\MakeCall\MakeCallInterface;
use ApiBuilder\MakeCall\MakeRawCallInterface;
use ApiBuilder\Service\Client\CallInterface;
use ApiBuilder\Service\PackageCollection;
use ApiBuilder\Service\Response\ResponseInterface;
use Symfony\Component\HttpClient\CurlHttpClient;
use ApiBuilder\Service\Client\Call;
use ApiBuilder\Service\Response\Response;

class MakeCall
{
    private CallInterface $call;
    private ResponseInterface $response;
    private MakeRawCallInterface $makeCall;
    private string $packageDtoClass;
    private array $parameters = [];

    private bool $callException = false;
    private bool $raw = false;

    public function __construct(
        MakeRawCallInterface $makeCall,
        string $packageDTOClass = '',
        ?CallInterface $call = null,
        ?ResponseInterface $response = null
    ) {
        $this->makeCall = $makeCall;
        $this->injectCall($call);
        $this->injectResponse($response);
        $this->packageDtoClass = $packageDTOClass;
    }

    private function injectCall(?CallInterface $call): void
    {
        if ($call === null) {
            $this->call = new Call(new CurlHttpClient());
        } else {
            $this->call = $call;
        }
    }

    private function injectResponse(?ResponseInterface $response): void
    {
        if ($response === null) {
            $this->response = new Response();
        } else {
            $this->response = $response;
        }
    }

    public function addParameters(array $parameters): MakeCall
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function addUrlEncodedParameters(array $parameters): MakeCall
    {
        $this->addParameters($this->encodeParameters($parameters));

        return $this;
    }

    private function encodeParameters(array $parameters): array
    {
        array_walk($parameters, function ($parameter) {
            return rawurlencode($parameter);
        });

        return $parameters;
    }

    public function isException(): bool
    {
        return $this->callException;
    }

    /**
     * If set to true will return original result as array, without using dto object
     */
    public function rawResponse(): MakeCall
    {
        $this->raw = true;

        return $this;
    }

    public function makeApiCall(): PackageCollection
    {
        $responseDto = $this->makeCall->makeCall($this->parameters, $this->call);
        $responseDto = $this->makeCall->processResponse($responseDto, $this->response);

        $this->callException = $responseDto->isException();

        $packageCollection = new PackageCollection();

        if ($this->raw === true) {
            return $this->makeRawDataResponse($packageCollection, $responseDto);
        }

        if ($this->makeCall instanceof MakeCallInterface) {
            if ($this->packageDtoClass === '') {
                throw new \Exception('Dto class not defined');
            }

            return $this->makeCall->packageResponse($responseDto, $this->packageDtoClass, $packageCollection);
        }

        return $packageCollection;
    }

    private function makeRawDataResponse(PackageCollection $packageCollection, ResponseDTO $responseDTO): PackageCollection
    {
        $rawDataDto = new RawDataDto();
        $rawDataDto->setRawData($responseDTO->getResponse());
        $packageCollection->add($rawDataDto);

        return $packageCollection;
    }
}
