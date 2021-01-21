<?php

namespace ApiBuilder\MakeCall\Google\Books;

use ApiBuilder\Base\Google\BaseBooks;
use ApiBuilder\DTO\Package\Google\Books\BookByVolumeIdDTO;
use ApiBuilder\DTO\ResponseDTO;
use ApiBuilder\MakeCall\MakeCallInterface;
use ApiBuilder\Service\Client\CallInterface;
use ApiBuilder\Service\PackageCollection;
use ApiBuilder\Service\Response\ResponseInterface;

class BookByVolumeIdCall extends BaseBooks implements MakeCallInterface
{
    public function makeCall(array $parameters, CallInterface $call): ResponseDTO
    {
        $volumeId = $parameters['volume_id'];
        unset($parameters['volume_id']);
        $endpoint = sprintf('volumes/%s', $volumeId);

        return $this->booksCallWithQueryKey($call, CallInterface::METHOD_GET, $endpoint);
    }

    public function processResponse(ResponseDTO $responseDTO, ResponseInterface $response): ResponseDTO
    {
        return $response->processResponse($responseDTO);
    }

    public function packageResponse(ResponseDTO $responseDTO, string $packageDTOClass, PackageCollection $packageCollection): PackageCollection
    {
        if ($responseDTO->isException()) {
            $exception = $responseDTO->getExceptionContent();
            $exception->setMessage('Error occurred fetching book');
            $packageCollection->add($exception);

            return $packageCollection;
        }

        $book = $responseDTO->getResponse();
        if (!isset($book['volumeInfo']) || empty($book['volumeInfo'])) {
            return $packageCollection;
        }
        $volumeInfo = $book['volumeInfo'];

        /** @var BookByVolumeIdDTO $bookDto */
        $bookDto = new $packageDTOClass();
        $bookDto->setTitle((isset($volumeInfo['title'])) ? $volumeInfo['title'] : '');
        $bookDto->setAuthors((isset($volumeInfo['authors'])) ? $volumeInfo['authors'] : []);
        $bookDto->setDimensions((isset($volumeInfo['dimensions'])) ? $volumeInfo['dimensions'] : []);
        $bookDto->setGooglePreview((isset($volumeInfo['previewLink'])) ? $volumeInfo['previewLink'] : '');
        $bookDto->setPublishedDate((isset($volumeInfo['publishedDate'])) ? $volumeInfo['publishedDate'] : '');
        $bookDto->setPublisher((isset($volumeInfo['publisher'])) ? $volumeInfo['publisher'] : '');

        $packageCollection->add($bookDto);

        return $packageCollection;
    }
}
