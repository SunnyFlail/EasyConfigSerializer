<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Serializer;

use SunnyFlail\EasyConfigSerializer\ArrayResolver\ArrayTypeResolverAggregate;
use SunnyFlail\EasyConfigSerializer\PropertyDeserializer\ArrayTypeDeserializer;
use SunnyFlail\EasyConfigSerializer\PropertyDeserializer\ClassTypeDeserializer;
use SunnyFlail\EasyConfigSerializer\PropertyDeserializer\ObjectTypeDeserializer;
use SunnyFlail\EasyConfigSerializer\PropertyDeserializer\PrimitiveTypeDeserializer;
use SunnyFlail\EasyConfigSerializer\PropertyDeserializer\PropertyDeserializerAggregate;

final readonly class StaticSerializerFactory
{
    public static function create(ISupportedClassesProvider $supportedClassesProvider): StaticSerializer
    {
        $arrayTypeResolver = new ArrayTypeResolverAggregate();
        $typeStringTransformer = new TypeStringTransformer($arrayTypeResolver);
        $propertyTypeResolver = new PropertyTypeResolver($typeStringTransformer);

        $propertyDeserializer = new PropertyDeserializerAggregate();

        $classDeserializer = new StaticClassDeserializer(
            $propertyTypeResolver,
            $propertyDeserializer,
        );

        $arrayTypeDeserializer = new ArrayTypeDeserializer($propertyDeserializer);
        $objectTypeDeserializer = new ObjectTypeDeserializer($propertyDeserializer);
        $classTypeDeserializer = new ClassTypeDeserializer($classDeserializer);
        $primitiveTypeDeserializer = new PrimitiveTypeDeserializer();

        $propertyDeserializer->registerDeserializer($arrayTypeDeserializer);
        $propertyDeserializer->registerDeserializer($objectTypeDeserializer);
        $propertyDeserializer->registerDeserializer($classTypeDeserializer);
        $propertyDeserializer->registerDeserializer($primitiveTypeDeserializer);

        return new StaticSerializer(
            $classDeserializer,
            $supportedClassesProvider,
        );
    }
}