<?php

namespace ApiBuilder\Service;


use ApiBuilder\DTO\Package\PackageDTOGeneral;
use ApiBuilder\DTO\Package\RawDataDto;

class PackageCollection implements \Iterator
{
    private array $packages = [];

    public function add(PackageDTOGeneral $package): void
    {
        $this->packages[] = $package;
    }

    public function get(int $offset): ?PackageDTOGeneral
    {
        if ($offset > count($this->packages) - 1) {
            return null;
        }

        return $this->packages[$offset];
    }

    public function first(): ?PackageDTOGeneral
    {
        if (empty($this->packages)) {
            return null;
        }

        return $this->packages[0];
    }

    public function isEmpty(): bool
    {
        return empty($this->packages);
    }

    public function all(): array
    {
        return $this->packages;
    }

    public function getRawData(): ?array
    {
        if (count($this->packages) > 1) {
            return null;
        }

        $rawDataDto = $this->packages[0];
        if (!$rawDataDto instanceof RawDataDto) {
            return null;
        }

        return $rawDataDto->getRawData();
    }

    public function current(): PackageDTOGeneral
    {
        return current($this->packages);
    }

    public function next(): ?PackageDTOGeneral
    {
        $next = next($this->packages);
        if ($next === false) {
            return null;
        }

        return $next;
    }

    public function key(): int
    {
        return (int) key($this->packages);
    }

    public function valid(): bool
    {
        $key = key($this->packages);
        if ($key === null) {
            return false;
        }

        return true;
    }

    public function rewind()
    {
        reset($this->packages);
    }
}
