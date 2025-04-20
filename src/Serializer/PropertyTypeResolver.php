<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Serializer;

use SunnyFlail\EasyConfigSerializer\Exception\Configuration\PropertyTypeIsNotDefinedException;
use SunnyFlail\EasyConfigSerializer\Types\PrimitiveTypeEnum;
use SunnyFlail\EasyConfigSerializer\Types\Types;

final readonly class PropertyTypeResolver
{
    public function __construct(
        private TypeStringTransformer $typeStringTransformer,
    ) {
    }

    public function getPropertyTypes(\ReflectionProperty $property): Types
    {
        $type = $property->getType();

        if (null === $type) {
            throw new PropertyTypeIsNotDefinedException($property);
        }

        $types = $this->resolveTypes($type);

        return $this->typeStringTransformer->transform($property, $types);
    }

    /**
     * @return string[]
     */
    private function resolveTypes(
        \ReflectionNamedType|\ReflectionUnionType|\ReflectionIntersectionType $type
    ): array {
        if (true === $type instanceof \ReflectionNamedType) {
            $types = [$type->getName()];

            if (true === $type->allowsNull()) {
                $types[] = PrimitiveTypeEnum::NULL;
            }

            return $types;
        }

        $types = [];

        foreach ($type->getTypes() as $subType) {
            $types = [...$types, ...$this->resolveTypes($subType)];
        }

        return array_unique($types);
    }
}