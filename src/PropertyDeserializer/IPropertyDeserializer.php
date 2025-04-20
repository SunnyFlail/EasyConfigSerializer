<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\PropertyDeserializer;

use SunnyFlail\EasyConfigSerializer\Exception\SchemaData\WrongDataTypeException;
use SunnyFlail\EasyConfigSerializer\Types\IType;

/**
 * @template TType of IType
 */
interface IPropertyDeserializer
{
    public function supports(IType $type): bool;

    /**
     * @param IType $type
     *
     * @throws WrongDataTypeException
     */
    public function deserialize(mixed $data, IType $type, \ReflectionProperty $property): mixed;
}