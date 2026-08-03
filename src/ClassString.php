<?php

declare(strict_types=1);

namespace OpenAPITools\Utils;

use function trim;

/** @api */
final readonly class ClassString
{
    public const string NAMESPACE_SEPARATOR = '\\';

    public static function factory(Namespace_ $namespace, string $relative): self
    {
        $namespace      = new Namespace_(
            trim($namespace->source, self::NAMESPACE_SEPARATOR),
            trim($namespace->test, self::NAMESPACE_SEPARATOR),
        );
        $relative       = Utils::className($relative);
        $fullyQualified = new Namespace_(
            self::NAMESPACE_SEPARATOR . trim(
                Utils::cleanUpNamespace($namespace->source . self::NAMESPACE_SEPARATOR . $relative),
                self::NAMESPACE_SEPARATOR,
            ),
            self::NAMESPACE_SEPARATOR . trim(
                Utils::cleanUpNamespace($namespace->test . self::NAMESPACE_SEPARATOR . $relative),
                self::NAMESPACE_SEPARATOR,
            ),
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
