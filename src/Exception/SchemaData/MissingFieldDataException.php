<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Exception\SchemaData;

final class MissingFieldDataException extends \Exception implements IInvalidSchemaDataException
{
    public function __construct(
        public readonly mixed $data,
        public readonly \ReflectionProperty $property,
        public readonly string $propertyName,
    ) {
        parent::__construct(sprintf(
            'Missing field data for property `%s`',
            $this->propertyName,
        ));
    }
}
