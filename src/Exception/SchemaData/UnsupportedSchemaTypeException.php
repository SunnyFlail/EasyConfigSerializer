<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Exception\SchemaData;

use SunnyFlail\EasyConfigSerializer\Data\IConfigSchema;

final class UnsupportedSchemaTypeException extends \Exception implements IInvalidSchemaDataException
{
    public function __construct(
        public readonly array $data,
    ) {
        parent::__construct(sprintf(
            'Unsupported schema type: %s',
            $data[IConfigSchema::SCHEMA_TYPE_FIELD_NAME] ?? 'UNDEFINED-SCHEMA-TYPE'
        ));
    }
}