<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Exception\Configuration;

final class PropertyTypeIsNotDefinedException extends \Exception implements ISchemaConfigurationException
{
    public function __construct(
        public readonly \ReflectionProperty $property,
    ) {
        parent::__construct(sprintf(
            'Property %s::%s does not have type defined',
            $this->property->getDeclaringClass()->getName(),
            $this->property->getName(),
        ));
    }
}
