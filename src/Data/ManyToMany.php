<?php

declare(strict_types=1);

namespace SunnyFlail\EasyConfigSerializer\Data;

use SunnyFlail\EasyConfigSerializer\Exception\Schema\ExcludingFieldsException;

final readonly class ManyToMany implements IRelation
{
    public const RELATED_ENTITY_CLASS_FIELD_NAME = 'relatedEntityClass';
    public const RELATED_ENTITY_SCHEMA_FIELD_NAME = 'relatedEntitySchema';

    public function __construct(
        public ?string $relatedEntityClass,
        public ?Entity $relatedEntitySchema,
    ) {
        $this->guard();
    }

    public static function getSchemaType(): string
    {
        return 'ManyToMany';
    }

    private function guard(): void
    {
        if (null !== $this->relatedEntityClass && null !== $this->relatedEntitySchema) {
            throw new ExcludingFieldsException(
                $this,
                'relatedEntityClass',
                'relatedEntitySchema',
            );
        }
    }
}