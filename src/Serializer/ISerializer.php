<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Serializer;

use SunnyFlail\EasyConfigSerializer\Data\IConfigSchema;

interface ISerializer
{
    public function serialize(IConfigSchema $schema): array;

    public function deserialize(array $data): mixed;
}
