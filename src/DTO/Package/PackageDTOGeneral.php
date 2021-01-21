<?php

namespace ApiBuilder\DTO\Package;

abstract class PackageDTOGeneral
{
    public function toArray(bool $toSnakeCase = true): array
    {
        $arrData = get_object_vars($this);
        if ($toSnakeCase === true) {
            $arrData = $this->convertKeysToSnakeCase($arrData);
        }

        return $arrData;
    }

    private function convertKeysToSnakeCase(array $arrData): array
    {
        $properties = array_keys($arrData);
        $values = array_values($arrData);
        array_walk($properties, function (&$property) {
            $matches = [];
            preg_match('/[A-Z]/', $property, $matches);
            if (!empty($matches)) {
                foreach ($matches as $match) {
                    $property = $this->composeConvertedStringPart($property, $match);
                }
            }

            $property = strtolower($property);
        });

        $converted = array_combine($properties, $values);

        return ($converted === false) ? $arrData : $converted;
    }

    private function composeConvertedStringPart(string $property, string $match): string
    {
        $offset = strpos($property, $match);
        if (empty($offset)) {
            return $property;
        }
        $firstPart = substr($property, 0, $offset);
        $secondPart = substr($property, $offset);
        $property = sprintf('%s_%s', $firstPart, $secondPart);

        return $property;
    }
}
