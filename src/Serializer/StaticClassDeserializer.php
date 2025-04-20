<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Serializer;

use SunnyFlail\EasyConfigSerializer\Data\IConfigSchema;
use SunnyFlail\EasyConfigSerializer\Data\ICanDeserializer;
use SunnyFlail\EasyConfigSerializer\Data\IDeserialize;
use SunnyFlail\EasyConfigSerializer\Data\IValidable;
use SunnyFlail\EasyConfigSerializer\Exception\Configuration\PropertyTypeIsNotDefinedException;
use SunnyFlail\EasyConfigSerializer\Exception\Schema\ISchemaValidationException;
use SunnyFlail\EasyConfigSerializer\Exception\SchemaData\MissingFieldDataException;
use SunnyFlail\EasyConfigSerializer\PropertyDeserializer\IPropertyDeserializer;
use SunnyFlail\EasyConfigSerializer\Types\Types;

final readonly class StaticClassDeserializer implements IClassDeserializer
{
    public function __construct(
        private PropertyTypeResolver  $propertyTypeResolver,
        private IPropertyDeserializer $propertyDeserializer,
    ) {
    }

    /**
     * @param class-string<IConfigSchema> $classFQCN
     */
    public function canDeserialize(array $data, string $classFQCN): bool
    {
        if (
            true === is_a($classFQCN, ICanDeserializer::class, true)
            && false === $classFQCN::canDeserialize($data)
        ) {
            return false;
        }

        if ($classFQCN::getSchemaType() !== ($data[$classFQCN::SCHEMA_TYPE_FIELD_NAME])) {
            return false;
        }

        return true;
    }

    /**
     * @template TClass of IConfigSchema
     *
     * @param class-string<TClass> $classFQCN
     *
     * @throws ISchemaValidationException
     *
     * @return TClass
     */
    public function deserializeToClass(array $data, string $classFQCN): mixed
    {
        if (false === self::canDeserialize($data, $classFQCN)) {
            throw new \InvalidArgumentException('Unsupported data');
        }

        if (true === \is_a($classFQCN, IDeserialize::class, true)) {
            return $classFQCN::deserialize($data, $this);
        }

        $reflection = new \ReflectionClass($classFQCN);
        $properties = $reflection->getProperties();
        $values = [];

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $typeReflection = $property->getType();

            if (null === $typeReflection) {
                throw new PropertyTypeIsNotDefinedException($property);
            }

            if (
                false === isset($data[$propertyName])
                && false === $property->getType()?->allowsNull()
            ) {
                throw new MissingFieldDataException(
                    $data,
                    $property,
                    $propertyName,
                );
            }

            $propertyTypes = $this->propertyTypeResolver->getPropertyTypes($property);
            $propertyData = $data[$propertyName] ?? null;

            $values[$propertyName] = $this->deserializeProperty($propertyData, $property, $propertyTypes);
        }

        $schema = $reflection->newInstance(...$values);

        if (true === $schema instanceof IValidable) {
            $schema->validate();
        }

        return $schema;
    }

    private function deserializeProperty(
        mixed               $data,
        \ReflectionProperty $property,
        Types               $propertyTypes,
    ): mixed {
        if (null === $data && false === $propertyTypes->nullable) {
            throw new MissingFieldDataException(
                $data,
                $property,
                $property->getName(),
            );
        }

        foreach ($propertyTypes->getTypes() as $type) {
            if (true === $this->propertyDeserializer->supports($type)) {
                return $this->propertyDeserializer->deserialize($data, $type, $property);
            }
        }

        throw new \InvalidArgumentException('Unsupported data');
    }
}