<?php

declare(strict_types=1);

namespace ApiClients\Tools\OpenApiClientGenerator\Representation;

final class Property
{
    /** @param array<PropertyType> $type */
    public function __construct(
        public readonly string $name,
        public readonly string $sourceName,
        public readonly string $description,
        public readonly ExampleData $example,
        /** @var array<PropertyType> $type */
        public readonly array $type,
        public readonly bool $nullable,
    ) {
    }
}
