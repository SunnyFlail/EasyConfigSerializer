<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Serializer;

use SunnyFlail\EasyConfigSerializer\ArrayResolver\ArrayObjectTypeResolver;
use SunnyFlail\EasyConfigSerializer\ArrayResolver\ArrayTypeResolverAggregate;
use SunnyFlail\EasyConfigSerializer\ArrayResolver\DictionaryResolver;
use SunnyFlail\EasyConfigSerializer\ArrayResolver\ListResolver;
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

        $listResolver = new ListResolver($typeStringTransformer);
        $dictionaryResolver = new DictionaryResolver($typeStringTransformer);
        $arrayObjectResolver = new ArrayObjectTypeResolver($typeStringTransformer);

        $propertyDeserializer->registerDeserializer($arrayTypeDeserializer);
        $propertyDeserializer->registerDeserializer($objectTypeDeserializer);
        $propertyDeserializer->registerDeserializer($classTypeDeserializer);
        $propertyDeserializer->registerDeserializer($primitiveTypeDeserializer);

        $arrayTypeResolver->registerTypeResolver($listResolver);
        $arrayTypeResolver->registerTypeResolver($dictionaryResolver);
        $arrayTypeResolver->registerTypeResolver($arrayObjectResolver);

        return new StaticSerializer(
            $classDeserializer,
            $supportedClassesProvider,
        );
    }
}