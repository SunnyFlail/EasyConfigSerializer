<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Types;

use SunnyFlail\EasyConfigSerializer\Exception\Configuration\ArrayTypeCannotBeNestedDirectlyInOtherArrayTypeException;

final readonly class ArrayType implements IArrayType
{
    public function __construct(
        public ArrayTypeEnum $type,
        public Types         $types,
    ) {
        $this->guard();
    }

    private function guard(): void
    {
        if (true === $this->types->includesArrayType()) {
            throw new ArrayTypeCannotBeNestedDirectlyInOtherArrayTypeException($this);
        }
    }
}