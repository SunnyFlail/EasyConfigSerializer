<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Data;

use SunnyFlail\EasyConfigSerializer\Serializer\ISerializer;

interface ISerialize
{
    public function serialize(ISerializer $serializer): array;
}