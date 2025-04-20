<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Serializer;

use SunnyFlail\EasyConfigSerializer\ArrayResolver\IArrayTypeResolver;
use SunnyFlail\EasyConfigSerializer\Attribute\IArray;
use SunnyFlail\EasyConfigSerializer\Exception\Configuration\MissingArrayTypeConfigurationException;
use SunnyFlail\EasyConfigSerializer\Exception\Configuration\TooManyArrayTypeDefinitionsException;
use SunnyFlail\EasyConfigSerializer\Types\ArrayType;
use SunnyFlail\EasyConfigSerializer\Types\ClassType;
use SunnyFlail\EasyConfigSerializer\Types\PrimitiveType;
use SunnyFlail\EasyConfigSerializer\Types\PrimitiveTypeEnum;
use SunnyFlail\EasyConfigSerializer\Types\Types;

final readonly class TypeStringTransformer
{
    public function __construct(
       private IArrayTypeResolver $arrayTypeResolver
    ) {
    }

    /**
     * @param string[] $types
     */
    public function transform(\ReflectionProperty $property, array $types): Types
    {
        $resolvedTypes = [];
        $nullable = false;

        foreach ($types as $type) {
            $primitiveType = PrimitiveTypeEnum::tryFrom($type);

            if (null !== $primitiveType) {
                $resolvedTypes[] = new PrimitiveType($primitiveType);
                continue;
            }

            if (PrimitiveTypeEnum::NULL === $type) {
                $nullable = true;
                continue;
            }

            if (PrimitiveTypeEnum::ARRAY === $type) {
                $resolvedTypes[] = $this->resolveArrayTypes($property);
                continue;
            }

            $resolvedTypes[] = new ClassType($type);
        }

        return new Types(
            $nullable,
            ...$resolvedTypes,
        );
    }

    private function resolveArrayTypes(\ReflectionProperty $property): ArrayType
    {
        $arrayAttributes = $property->getAttributes(IArray::class);
        $arrayAttributesCount = \count($arrayAttributes);

        if (0 === $arrayAttributesCount) {
            throw new MissingArrayTypeConfigurationException($property);
        }

        if (1 !== $arrayAttributesCount) {
            throw new TooManyArrayTypeDefinitionsException($property);
        }

        /** @var IArray $arrayAttribute */
        $arrayAttribute = $arrayAttributes[0]->newInstance();

        return $this->arrayTypeResolver->resolve($property, $arrayAttribute);
    }
}