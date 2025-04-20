<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Attribute;

final readonly class ArrayObjectProperty
{
    /**
     * @var string[]
     */
    public array $types;

    public function __construct(
        public string $propertyName,
        public bool   $required,
        string        ...$types,
    ) {
        $this->types = $types;
    }
}