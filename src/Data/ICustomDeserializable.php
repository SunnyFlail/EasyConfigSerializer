<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Data;
interface ICustomDeserializable
{
    public static function canDeserialize(array $data): bool;
}