<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Exception\SchemaData;

use SunnyFlail\EasyConfigSerializer\PropertyDeserializer\IPropertyDeserializer;
use SunnyFlail\EasyConfigSerializer\Types\IType;

final class WrongDataTypeException extends \Exception implements IInvalidSchemaDataException
{
    public function __construct(
        public readonly IPropertyDeserializer $propertyDeserializer,
        public readonly IType $type,
        public readonly mixed $data,
        public readonly \ReflectionProperty $property,
        public readonly string $expectedType,
    ) {
        parent::__construct(sprintf(
            '%s with type %s expected data to be of type %s',
            $this->propertyDeserializer::class,
            $this->type::class,
            $this->expectedType,
        ));
    }
}
