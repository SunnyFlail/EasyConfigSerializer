<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\ArrayResolver;

use SunnyFlail\EasyConfigSerializer\Attribute\ArrayObject;
use SunnyFlail\EasyConfigSerializer\Attribute\IArray;
use SunnyFlail\EasyConfigSerializer\Exception\Configuration\UnsupportedArrayTypeException;
use SunnyFlail\EasyConfigSerializer\Serializer\TypeStringTransformer;
use SunnyFlail\EasyConfigSerializer\Types\IArrayType;
use SunnyFlail\EasyConfigSerializer\Types\IType;
use SunnyFlail\EasyConfigSerializer\Types\ObjectProperty;
use SunnyFlail\EasyConfigSerializer\Types\ObjectType;
use SunnyFlail\EasyConfigSerializer\Types\Types;

/**
 * @template-implements IArrayTypeResolver<ArrayObject, ObjectType>
 */
final readonly class ArrayObjectTypeResolver implements IArrayTypeResolver
{
    public function __construct(
        private TypeStringTransformer $typeStringTransformer,
    ) {
    }

    public function supports(IArray $definition): bool
    {
        return $definition instanceof ArrayObject;
    }

    public function resolve(\ReflectionProperty $property, IArray $definition): IArrayType
    {
        if (false === $this->supports($definition)) {
            throw new UnsupportedArrayTypeException($property, $definition);
        }

        $properties = [];

        foreach ($definition->properties as $objectProperty) {
            $types = $this->deserializeTypes(...$objectProperty->types);

            $properties[] = new ObjectProperty(
                $objectProperty->name,
                $objectProperty->nullable,
                new Types(...$types),
            );
        }

        return new ObjectType(...$properties);
    }

    /**
     * @return iterable<IType>
     */
    private function deserializeTypes(\ReflectionProperty $property, string ...$types): iterable
    {
        foreach ($types as $type) {
            yield $this->typeStringTransformer->transform($property, $type);
        }
    }
}