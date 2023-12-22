<?php

declare(strict_types=1);

namespace OpenAPITools\Utils;

use function trim;

final readonly class ClassString
{
    public static function factory(Namespace_ $namespace, string $relative): self
    {
        $namespace      = new Namespace_(
            trim($namespace->source, '\\'),
            trim($namespace->test, '\\'),
        );
        $relative       = Utils::className($relative);
        $fullyQualified = new Namespace_(
            Utils::cleanUpNamespace($namespace->source . '\\' . $relative),
            Utils::cleanUpNamespace($namespace->test . '\\' . $relative),
        );

        return new self(
            $namespace,
            new Namespace_(
                Utils::dirname($fullyQualified->source),
                Utils::dirname($fullyQualified->test),
            ),
            $fullyQualified,
            $relative,
            Utils::basename($relative),
        );
    }

    private function __construct(
        public Namespace_ $baseNamespace,
        public Namespace_ $namespace,
        public Namespace_ $fullyQualified,
        public string $relative,
        public string $className,
    ) {
    }
}
