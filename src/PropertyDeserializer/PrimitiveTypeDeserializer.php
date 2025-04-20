<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\PropertyDeserializer;

use SunnyFlail\EasyConfigSerializer\Exception\Configuration\NotSupportedTypeDeserializationException;
use SunnyFlail\EasyConfigSerializer\Exception\SchemaData\WrongDataTypeException;
use SunnyFlail\EasyConfigSerializer\Types\IType;
use SunnyFlail\EasyConfigSerializer\Types\PrimitiveType;
use SunnyFlail\EasyConfigSerializer\Types\PrimitiveTypeEnum;

/**
 * @template-implements IPropertyDeserializer<PrimitiveType>
 */
final readonly class PrimitiveTypeDeserializer implements IPropertyDeserializer
{
    public function supports(IType $type): bool
    {
        return $type instanceof PrimitiveType;
    }

    public function deserialize(mixed $data, IType $type, \ReflectionProperty $property): mixed
    {
        if (false === $this->supports($type)) {
            throw new NotSupportedTypeDeserializationException($this, $type);
        }

        if (false === $type->type->isOfRequiredType($data)) {
            throw new WrongDataTypeException(
                $this,
                $type,
                $data,
                $property,
                $type->type->value,
            );
        }

        return match ($type->type) {
            PrimitiveTypeEnum::BOOL => (bool) $data,
            PrimitiveTypeEnum::INTEGER => (int) $data,
            PrimitiveTypeEnum::FLOAT => (float) $data,
            PrimitiveTypeEnum::STRING => (string) $data,
            default => throw new NotSupportedTypeDeserializationException($this, $type),
        };
    }
}