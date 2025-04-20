<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Exception\Schema;

use SunnyFlail\EasyConfigSerializer\Data\IConfigSchema;

class InvalidSchemaException extends \DomainException implements ISchemaValidationException
{
    public function __construct(
        public readonly IConfigSchema $schema,
        string $message,
    ) {
        parent::__construct($message);
    }

    final public function getSchema(): IConfigSchema
    {
        return $this->schema;
    }
}