<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\PropertyDeserializer;

use SunnyFlail\EasyConfigSerializer\Exception\Configuration\NotSupportedTypeDeserializationException;
use SunnyFlail\EasyConfigSerializer\Exception\SchemaData\WrongDataTypeException;
use SunnyFlail\EasyConfigSerializer\Types\ArrayType;
use SunnyFlail\EasyConfigSerializer\Types\IType;

/**
 * @template-implements IPropertyDeserializer<ArrayType>
 */
final readonly class ArrayTypeDeserializer implements IPropertyDeserializer
{
    public function __construct(
        private IPropertyDeserializer $propertyDeserializer,
    ) {
    }

    public function supports(IType $type): bool
    {
        return $type instanceof ArrayType;
    }

    public function deserialize(mixed $data, IType $type, \ReflectionProperty $property): mixed
    {
        if (false === $this->supports($type)) {
            throw new NotSupportedTypeDeserializationException($this, $type);
        }

        if (false === is_array($data)) {
            throw new WrongDataTypeException(
                $this,
                $type,
                $data,
                $property,
                'array',
            );
        }

        $values = [];

        foreach ($data as $key => $value) {
            $values[$key] = $this->propertyDeserializer->deserialize($value, $type, $property);
        }

        return $values;
    }
}