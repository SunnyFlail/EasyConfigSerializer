<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Serializer;

use SunnyFlail\EasyConfigSerializer\Data\IConfigSchema;

interface IClassDeserializer
{
    /**
     * @param class-string<IConfigSchema> $classFQCN
     */
    public function canDeserialize(array $data, string $classFQCN): bool;

    /**
     * @template TClass of IConfigSchema
     *
     * @param class-string<TClass> $classFQCN
     *
     * @return TClass
     */
    public function deserializeToClass(array $data, string $classFQCN): mixed;
}