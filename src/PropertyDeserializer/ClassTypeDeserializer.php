<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\PropertyDeserializer;

use SunnyFlail\EasyConfigSerializer\Exception\Configuration\CannotDeserializeNotBackedEnumException;
use SunnyFlail\EasyConfigSerializer\Exception\Configuration\NotSupportedTypeDeserializationException;
use SunnyFlail\EasyConfigSerializer\Exception\SchemaData\WrongDataTypeException;
use SunnyFlail\EasyConfigSerializer\Serializer\IClassDeserializer;
use SunnyFlail\EasyConfigSerializer\Types\ClassType;
use SunnyFlail\EasyConfigSerializer\Types\IType;
use SunnyFlail\EasyConfigSerializer\Types\PrimitiveTypeEnum;

/**
 * @template-implements IPropertyDeserializer<ClassType>
 */
final readonly class ClassTypeDeserializer implements IPropertyDeserializer
{
    public function __construct(
        private IClassDeserializer $classDeserializer,
    ) {
    }

    public function supports(IType $type): bool
    {
        return true === $type instanceof ClassType;
    }

    /**
     * @param ClassType $type
     */
    public function deserialize(mixed $data, IType $type, \ReflectionProperty $property): mixed
    {
        if (false === $this->supports($type)) {
            throw new NotSupportedTypeDeserializationException($this, $type);
        }

        $reflectionClass = new \ReflectionClass($type->classFQCN);

        if (true === $reflectionClass->isEnum()) {
            return $this->deserializeEnum($data, $type, $property);
        }

        return $this->deserializeClass($data, $type);
    }

    private function deserializeEnum(
        mixed     $data,
        ClassType $type,
        \ReflectionProperty $property,
    ): mixed {

        $reflectionEnum = new \ReflectionEnum($type->classFQCN);

        if (false === $reflectionEnum->isBacked()) {
            throw new CannotDeserializeNotBackedEnumException($data, $type);
        }

        $requiredType = PrimitiveTypeEnum::tryFrom($reflectionEnum->getBackingType()->getName());

        if (false === $requiredType->isOfRequiredType($data)) {
            throw new WrongDataTypeException(
                $this,
                $type,
                $data,
                $property,
                $requiredType->value,
            );
        }

        foreach ($reflectionEnum->getCases() as $case) {
            if ($data === $case->getValue()->name) {
                return $case->getValue();
            }
        }

        throw new \InvalidArgumentException();
    }

    private function deserializeClass(
        mixed     $data,
        ClassType $type,
    ): object {
        return $this->classDeserializer->deserializeToClass($data, $type->classFQCN);
    }
}