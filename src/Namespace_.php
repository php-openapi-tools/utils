<?php

declare(strict_types=1);

namespace OpenAPITools\Utils;

final readonly class Namespace_ //phpcs:disable
{
    public function __construct(
        public string $source,
        public string $test,
    ) {
    }
}
