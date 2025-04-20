<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Exception\Configuration;

final class TooManyArrayTypeDefinitionsException extends \DomainException
{
    public function __construct(
        public readonly \ReflectionProperty $property,
    ) {
        parent::__construct(sprintf(
            'Too many array type definitions for %s::%s',
            $this->property->getDeclaringClass()->getName(),
            $this->property->getName(),
        ));
    }
}