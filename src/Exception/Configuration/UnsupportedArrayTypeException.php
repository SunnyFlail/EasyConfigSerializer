<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Exception\Configuration;

use SunnyFlail\EasyConfigSerializer\Attribute\IArray;

final class UnsupportedArrayTypeException extends \Exception implements ISchemaConfigurationException
{
    public function __construct(
        public readonly \ReflectionProperty $property,
        public readonly IArray $definition,
    ) {
        parent::__construct(sprintf(
            'Unsupported array type for %s::%s: %s',
            $property->getDeclaringClass()->getName(),
            $property->getName(),
            $definition::class,
        ));
    }
}