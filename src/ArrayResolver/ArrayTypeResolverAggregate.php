<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\ArrayResolver;

use SunnyFlail\EasyConfigSerializer\Attribute\IArray;
use SunnyFlail\EasyConfigSerializer\Exception\Configuration\UnsupportedArrayTypeException;
use SunnyFlail\EasyConfigSerializer\Types\IArrayType;

/**
 * @template-implements IArrayTypeResolver<IArray, IArrayType>
 */
final class ArrayTypeResolverAggregate implements IArrayTypeResolver
{
    /**
     * @var IArrayTypeResolver[]
     */
    private array $arrayTypeResolvers;

    public function __construct(
        IArrayTypeResolver ...$arrayTypeResolvers
    ) {
        $this->arrayTypeResolvers = $arrayTypeResolvers;
    }

    public function registerTypeResolver(IArrayTypeResolver $typeResolver): void
    {
        if (true === $typeResolver instanceof ArrayTypeResolverAggregate) {
            throw new \LogicException('Cannot register aggregate as a resolver.');
        }

        $this->arrayTypeResolvers[] = $typeResolver;
    }

    public function supports(IArray $definition): bool
    {
        foreach ($this->arrayTypeResolvers as $arrayTypeResolver) {
            if (true === $arrayTypeResolver->supports($definition)) {
                return true;
            }
        }

        return false;
    }

    public function resolve(\ReflectionProperty $property, IArray $definition): IArrayType
    {
        foreach ($this->arrayTypeResolvers as $arrayTypeResolver) {
            if (true === $arrayTypeResolver->supports($definition)) {
                return $arrayTypeResolver->resolve($property, $definition);
            }
        }

        throw new UnsupportedArrayTypeException($property, $definition);
    }
}