<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Data;

interface IValidable
{
    /**
     * @throws ISchemaValidationException
     */
    public function validate(): void;
}