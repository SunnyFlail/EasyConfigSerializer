<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Exception\Configuration;

use SunnyFlail\EasyConfigSerializer\Types\ArrayType;

final class ArrayTypeCannotBeNestedDirectlyInOtherArrayTypeException extends \Exception
{
    public function __construct(
        public readonly ArrayType $type,
    ) {
        parent::__construct('Array type cannot have an array type nested directly below it');
    }
}