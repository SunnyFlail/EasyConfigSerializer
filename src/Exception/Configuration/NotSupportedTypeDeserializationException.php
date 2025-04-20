<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Exception\Configuration;

use SunnyFlail\EasyConfigSerializer\PropertyDeserializer\IPropertyDeserializer;
use SunnyFlail\EasyConfigSerializer\Types\IType;

final class NotSupportedTypeDeserializationException extends \Exception implements ISchemaConfigurationException
{
    public function __construct(
        public readonly IPropertyDeserializer $propertyDeserializer,
        public readonly IType $type
    ) {
        parent::__construct(sprintf(
            '%s does not support type %s',
            $this->propertyDeserializer::class,
            $this->type::class,
        ));
    }
}
