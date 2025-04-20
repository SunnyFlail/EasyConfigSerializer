<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\ArrayResolver;

use SunnyFlail\EasyConfigSerializer\Attribute\IArray;
use SunnyFlail\EasyConfigSerializer\Types\IArrayType;

/**
 * @template TDefinition of IArray
 * @template TType of IArrayType
 */
interface IArrayTypeResolver
{
    /**
     * @psalm-assert-if-true TDefinition $definition
     */
    public function supports(IArray $definition): bool;

    /**
     * @param TDefinition $definition
     *
     * @return TType
     */
    public function resolve(\ReflectionProperty $property, IArray $definition): IArrayType;
}