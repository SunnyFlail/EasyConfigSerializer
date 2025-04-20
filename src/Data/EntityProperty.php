<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Data;

final readonly class EntityProperty implements IConfigSchema
{
    public function __construct(
        public string $name,
    ) {
    }

    public static function getSchemaType(): string
    {
        return 'entity-property';
    }
}