<?php

namespace ApiBuilder\DTO\Package;

class RawDataDto extends PackageDTOGeneral
{
    protected array $rawData;

    public function getRawData(): array
    {
        return $this->rawData;
    }

    public function setRawData(array $rawData): void
    {
        $this->rawData = $rawData;
    }
}
