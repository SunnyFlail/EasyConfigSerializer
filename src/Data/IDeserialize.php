<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Data;

use SunnyFlail\EasyConfigSerializer\Serializer\IClassDeserializer;

interface IDeserialize
{
    public static function deserialize(array $data, IClassDeserializer $serializer): static;
}