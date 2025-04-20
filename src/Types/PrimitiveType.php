<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Types;

final readonly class PrimitiveType implements IType
{
    public function __construct(
        public PrimitiveTypeEnum $type,
    ) {
    }
}