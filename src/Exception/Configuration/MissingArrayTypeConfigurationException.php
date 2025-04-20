<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Exception\Configuration;

final class MissingArrayTypeConfigurationException extends \Exception implements ISchemaConfigurationException
{
    public function __construct(
        public readonly \ReflectionProperty $property,
    ) {
        parent::__construct(sprintf(
            'Array type definition missing for %s::%s',
            $this->property->getDeclaringClass()->getName(),
            $this->property->getName(),
        ));
    }
}