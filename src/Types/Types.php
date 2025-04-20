<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Types;

final readonly class Types
{
    /**
     * @var array<IType>
     */
    private array $types;

    public function __construct(
        public bool $nullable,
        IType       ...$types,
    ) {
        $this->types = $types;
    }

    /**
     * @return iterable<IType>
     */
    public function getTypes(): iterable
    {
        $objectTypes = [];
        $primitiveTypes = [];

        foreach ($this->types as $type) {
            if ($type instanceof ArrayType) {
                yield $type;
            }

            if ($type instanceof ClassType) {
                $objectTypes[] = $type;
                continue;
            }

            if ($type instanceof PrimitiveTypeEnum) {
                $primitiveTypes[] = $type;
                continue;
            }
        }

        foreach ($objectTypes as $objectType) {
            yield $objectType;
        }

        foreach ($primitiveTypes as $primitiveType) {
            yield $primitiveType;
        }
    }

    public function includesArrayType(): bool
    {
        foreach ($this->types as $type) {
            if ($type instanceof ArrayType) {
                return true;
            }
        }

        return false;
    }
}