<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\ArrayResolver;

use SunnyFlail\EasyConfigSerializer\Attribute\Dictionary;
use SunnyFlail\EasyConfigSerializer\Attribute\IArray;
use SunnyFlail\EasyConfigSerializer\Exception\Configuration\UnsupportedArrayTypeException;
use SunnyFlail\EasyConfigSerializer\Serializer\TypeStringTransformer;
use SunnyFlail\EasyConfigSerializer\Types\ArrayType;
use SunnyFlail\EasyConfigSerializer\Types\ArrayTypeEnum;
use SunnyFlail\EasyConfigSerializer\Types\IArrayType;

/**
 * @template-implements IArrayTypeResolver<Dictionary, ArrayType>
 */
final readonly class DictionaryResolver implements IArrayTypeResolver
{
    public function __construct(
        private TypeStringTransformer $typeStringTransformer,
    ) {
    }

    public function supports(IArray $definition): bool
    {
        return true === $definition instanceof Dictionary;
    }

    public function resolve(\ReflectionProperty $property, IArray $definition): IArrayType
    {
        if (false === $this->supports($definition)) {
            throw new UnsupportedArrayTypeException($property, $definition);
        }

        return new ArrayType(
            ArrayTypeEnum::DICTIONARY,
            $this->typeStringTransformer->transform($property, $definition->properties),
        );
    }
}