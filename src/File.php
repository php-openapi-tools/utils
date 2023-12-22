<?php

declare(strict_types=1);

namespace OpenAPITools\Utils;

use PhpParser\Node;

final readonly class File
{
    public function __construct(
        public string $pathPrefix,
        public string $fqcn,
        public Node|string $contents,
    ) {
    }
}
