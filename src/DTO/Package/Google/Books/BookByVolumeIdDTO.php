<?php

namespace ApiBuilder\DTO\Package\Google\Books;

use ApiBuilder\DTO\Package\PackageDTOGeneral;

class BookByVolumeIdDTO extends PackageDTOGeneral
{
    protected string $title;

    protected array $authors;

    protected string $publisher;

    protected string $publishedDate;

    protected array $dimensions;

    protected string $googlePreview;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getAuthors(): array
    {
        return $this->authors;
    }

    public function setAuthors(array $authors): void
    {
        $this->authors = $authors;
    }

    public function getPublisher(): string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): void
    {
        $this->publisher = $publisher;
    }

    public function getPublishedDate(): string
    {
        return $this->publishedDate;
    }

    public function setPublishedDate(string $publishedDate): void
    {
        $this->publishedDate = $publishedDate;
    }

    public function getDimensions(): array
    {
        return $this->dimensions;
    }

    public function setDimensions(array $dimensions): void
    {
        $this->dimensions = $dimensions;
    }

    public function getGooglePreview(): string
    {
        return $this->googlePreview;
    }

    public function setGooglePreview(string $googlePreview): void
    {
        $this->googlePreview = $googlePreview;
    }
}
