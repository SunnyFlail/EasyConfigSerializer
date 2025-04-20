<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Data;

final readonly class Entity implements IConfigSchema
{
    public function __construct(
    ) {
    }

    public static function getSchemaType(): string
    {
        return 'entity';
    }
}