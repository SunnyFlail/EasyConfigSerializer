<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\PropertyDeserializer;

use SunnyFlail\EasyConfigSerializer\Exception\Configuration\NotSupportedTypeDeserializationException;
use SunnyFlail\EasyConfigSerializer\Types\IType;

/**
 * @template-implements IPropertyDeserializer<IType>
 */
final class PropertyDeserializerAggregate implements IPropertyDeserializer
{
    /**
     * @var IPropertyDeserializer[]
     */
    private array $propertyDeserializers;

    public function __construct(
        IPropertyDeserializer ...$propertyDeserializers
    ) {
        $this->propertyDeserializers = $propertyDeserializers;
    }

    public function registerDeserializer(IPropertyDeserializer $propertyDeserializer): void
    {
        $this->propertyDeserializers[] = $propertyDeserializer;
    }

    public function supports(IType $type): bool
    {
        foreach ($this->propertyDeserializers as $propertyDeserializer) {
            if (true === $propertyDeserializer->supports($type)) {
                return true;
            }
        }

        return false;
    }

    public function deserialize(mixed $data, IType $type, \ReflectionProperty $property): mixed
    {
        foreach ($this->propertyDeserializers as $propertyDeserializer) {
            if (true === $propertyDeserializer->supports($type)) {
                return $propertyDeserializer->deserialize($data, $type, $property);
            }
        }

        throw new NotSupportedTypeDeserializationException($this, $type);
    }
}