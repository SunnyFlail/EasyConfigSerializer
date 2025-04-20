<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Exception\Schema;

use SunnyFlail\EasyConfigSerializer\Data\IConfigSchema;

final class ExcludingFieldsException extends InvalidSchemaException
{
    /** @var string[] */
    public readonly array $fieldNames;

    public function __construct(
        IConfigSchema $schema,
        string ...$fieldNames,
    ) {
        parent::__construct(
            $schema,
            sprintf(
                'Fields %s cannot be defined at the same time',
                implode(', ', $fieldNames),
            )
        );

        $this->fieldNames = $fieldNames;
    }
}