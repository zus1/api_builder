<?php

namespace ApiBuilder\DTO\Package;

class ApiExceptionDTO extends PackageDTOGeneral
{
    private int $code;
    private string $message = '';

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
