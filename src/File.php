<?php

declare(strict_types=1);

namespace OpenAPITools\Utils;

use PhpParser\Node;

final readonly class File
{
    public const DO_LOAD_ON_WRITE     = true;
    public const DO_NOT_LOAD_ON_WRITE = false;

    public function __construct(
        public string $pathPrefix,
        public string $fqcn,
        public Node|string $contents,
        public bool $loadOnWrite,
    ) {
    }
}
