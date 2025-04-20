<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Attribute;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_PARAMETER)]
/**
 * Array that mimics an object - specifying required fields
 */
final readonly class ArrayObject implements IArray
{
    /**
     * @var ArrayObjectProperty[]
     */
    public array $properties;

    public function __construct(
        ArrayObjectProperty ...$properties,
    ) {
        $this->properties = $properties;
    }
}