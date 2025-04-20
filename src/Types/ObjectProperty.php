<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Types;

final readonly class ObjectProperty
{
    public function __construct(
        public string $name,
        public bool $nullable,
        public Types $type,
    ) {
    }
}