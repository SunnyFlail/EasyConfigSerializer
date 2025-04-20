<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Data;

interface IConfigSchema
{
    public const SCHEMA_TYPE_FIELD_NAME = 'schemaType';

    public static function getSchemaType(): string;
}