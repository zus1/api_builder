<?php

namespace ApiBuilder\DTO\Package\Google\Books;

use ApiBuilder\DTO\Package\PackageDTOGeneral;

final class BooksByTitleDTO extends PackageDTOGeneral
{
    protected string $title;
    protected array $authors;
    protected string $publisher;
    protected string $publishDate;

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

    public function getPublishDate(): string
    {
        return $this->publishDate;
    }

    public function setPublishDate(string $publishDate): void
    {
        $this->publishDate = $publishDate;
    }
}
