<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Types;

use SunnyFlail\EasyConfigSerializer\Exception\Configuration\ObjectTypeHasMultiplePropertiesOfSameNameException;

final readonly class ObjectType implements IArrayType
{
    /**
     * @var ObjectProperty[]
     */
    public array $objectProperties;

    public function __construct(
        ObjectProperty ...$objectProperties,
    ) {
        $this->objectProperties = $objectProperties;

        $this->guard();
    }

    private function guard(): void
    {
        $names = [];

        foreach ($this->objectProperties as $objectProperty) {
            if (true === isset($names[$objectProperty->name])) {
                throw new ObjectTypeHasMultiplePropertiesOfSameNameException($this);
            }

            $names[$objectProperty->name] = true;
        }
    }
}