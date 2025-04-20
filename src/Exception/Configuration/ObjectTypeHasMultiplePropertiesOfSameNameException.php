<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Exception\Configuration;

use SunnyFlail\EasyConfigSerializer\Types\ObjectType;

final class ObjectTypeHasMultiplePropertiesOfSameNameException extends \Exception implements ISchemaConfigurationException
{
    public function __construct(
        public readonly ObjectType $type,
    ) {
        parent::__construct('Object type cannot have multiple properties of same name');
    }
}