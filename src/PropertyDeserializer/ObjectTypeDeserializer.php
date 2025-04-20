<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\PropertyDeserializer;

use SunnyFlail\EasyConfigSerializer\Exception\Configuration\NotSupportedTypeDeserializationException;
use SunnyFlail\EasyConfigSerializer\Exception\SchemaData\MissingFieldDataException;
use SunnyFlail\EasyConfigSerializer\Exception\SchemaData\WrongDataTypeException;
use SunnyFlail\EasyConfigSerializer\Types\IType;
use SunnyFlail\EasyConfigSerializer\Types\ObjectType;

/**
 * @template-implements IPropertyDeserializer<ObjectType>
 */
final readonly class ObjectTypeDeserializer implements IPropertyDeserializer
{
    public function __construct(
        private IPropertyDeserializer $propertyDeserializer,
    ) {
    }

    public function supports(IType $type): bool
    {
        return true === $type instanceof ObjectType;
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

        $properties = [];

        foreach ($type->objectProperties as $objectProperty) {
            if (false === isset($data[$objectProperty->name])) {
                if (false === $objectProperty->nullable) {
                    throw new MissingFieldDataException(
                        $data,
                        $property,
                        $objectProperty->name,
                    );
                }

                $properties[$objectProperty->name] = null;
                continue;
            }

            $properties[$objectProperty->name] = $this->propertyDeserializer->deserialize(
                $data[$objectProperty->name],
                $objectProperty,
                $property,
            );
        }

        return $properties;
    }
}