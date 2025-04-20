<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Serializer;

use SunnyFlail\EasyConfigSerializer\Data\IConfigSchema;

interface ISupportedClassesProvider
{
    /**
     * @return iterable<class-string<IConfigSchema>>
     */
    public function getSupportedClasses(): iterable;
}