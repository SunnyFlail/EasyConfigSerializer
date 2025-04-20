<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Types;

final readonly class ClassType implements IType
{
    public string $classFQCN;

    public function __construct(string $classFQCN) {
        if (false === str_starts_with($classFQCN, '\\')) {
            $classFQCN = '\\' . $classFQCN;
        }

        $this->classFQCN = $classFQCN;
    }
}