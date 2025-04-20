<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Serializer;

use SunnyFlail\EasyConfigSerializer\Data\IConfigSchema;
use SunnyFlail\EasyConfigSerializer\Exception\SchemaData\UnsupportedSchemaTypeException;

final readonly class StaticSerializer implements ISerializer
{
    public function __construct(
        private IClassDeserializer $classDeserializer,
        private ISupportedClassesProvider $supportedClassesProvider,
    ) {
    }

    public function serialize(IConfigSchema $schema): array
    {
        $data = [];
        $data[$schema::SCHEMA_TYPE_FIELD_NAME] = $schema::getSchemaType();

        foreach (get_object_vars($schema) as $key => $value) {
            if (null === $value) {
                continue;
            }

            if (false === is_object($value)) {
                $data[$key] = $value;

                continue;
            }

            $data[$key] = self::serialize($value);
        }

        return $data;
    }

    public function deserialize(array $data): mixed
    {
        foreach ($this->supportedClassesProvider->getSupportedClasses() as $classFQCN) {
            if (false === $this->classDeserializer->canDeserialize($data, $classFQCN)) {
                continue;
            }

            return $this->classDeserializer->deserializeToClass($data, $classFQCN);
        }

        throw new UnsupportedSchemaTypeException($data);
    }
}