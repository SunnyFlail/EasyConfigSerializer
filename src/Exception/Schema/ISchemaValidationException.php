<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Exception\Schema;

use SunnyFlail\EasyConfigSerializer\Data\IConfigSchema;

interface ISchemaValidationException extends \Throwable
{
    public function getSchema(): IConfigSchema;
}