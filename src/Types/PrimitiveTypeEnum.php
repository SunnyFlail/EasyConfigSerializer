<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Types;
enum PrimitiveTypeEnum: string
{
    const MIXED = 'mixed';
    const ARRAY = 'array';
    const NULL = 'null';
    case INTEGER = 'int';
    case FLOAT = 'float';
    case BOOL = 'bool';
    case STRING = 'string';

    public function isOfRequiredType(mixed $value): bool
    {
        return match ($this) {
            PrimitiveTypeEnum::BOOL => true === is_bool($value) || 0 === $value || 1 === $value,
            PrimitiveTypeEnum::INTEGER => true === is_int($value) || is_numeric($value),
            PrimitiveTypeEnum::STRING => true === is_string($value),
            PrimitiveTypeEnum::FLOAT => true === is_float($value),
        };
    }
}