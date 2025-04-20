<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Exception\Configuration;

use SunnyFlail\EasyConfigSerializer\Types\ClassType;

final class CannotDeserializeNotBackedEnumException extends \Exception
{
    public function __construct(
        public readonly array $data,
        public readonly ClassType $type,
    ) {
        parent::__construct(sprintf(
           '',

        ));
    }
}