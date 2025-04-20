<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Attribute;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_PARAMETER)]
/**
 * Array that is incrementing number indexed
 */
final readonly class ListArray implements IArray
{
    /**
     * @var string[]
     */
    public array $types;

    public function __construct(
        string ...$types,
    ) {
        $this->types = $types;
    }
}