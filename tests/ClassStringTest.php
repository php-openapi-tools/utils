<?php

declare(strict_types=1);

namespace OpenAPITools\Tests\Utils;

use OpenAPITools\Utils\ClassString;
use OpenAPITools\Utils\Namespace_;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use WyriHaximus\TestUtilities\TestCase;

final class ClassStringTest extends TestCase
{
    /** @return iterable<array<Namespace_|string>> */
    public static function factoryDataProvider(): iterable
    {
        yield [
            new Namespace_(
                'OpenAPITools\Utils',
                'OpenAPITools\Tests\Tools\Utils',
            ),
            'ClassString',
            'ClassString',
            'ClassString',
            'OpenAPITools\Utils',
            'OpenAPITools\Tests\Tools\Utils',
            'OpenAPITools\Utils',
            'OpenAPITools\Tests\Tools\Utils',
            ClassString::NAMESPACE_SEPARATOR . ClassString::class,
            '\OpenAPITools\Tests\Tools\Utils\ClassString',
        ];

        yield [
            new Namespace_(
                'OpenAPITools',
                'OpenAPITools\Tests\Tools',
            ),
            'Utils\ClassString',
            'Utils\ClassString',
            'ClassString',
            'OpenAPITools',
            'OpenAPITools\Tests\Tools',
            'OpenAPITools\Utils',
            'OpenAPITools\Tests\Tools\Utils',
            ClassString::NAMESPACE_SEPARATOR . ClassString::class,
            '\OpenAPITools\Tests\Tools\Utils\ClassString',
        ];

        yield [
            new Namespace_(
                '\OpenAPITools\\',
                '\OpenAPITools\Tests\Tools\\',
            ),
            '\Utils\ClassString\\',
            'Utils\ClassString',
            'ClassString',
            'OpenAPITools',
            'OpenAPITools\Tests\Tools',
            'OpenAPITools\Utils',
            'OpenAPITools\Tests\Tools\Utils',
            ClassString::NAMESPACE_SEPARATOR . ClassString::class,
            '\OpenAPITools\Tests\Tools\Utils\ClassString',
        ];
    }

    #[Test]
    #[DataProvider('factoryDataProvider')]
    public function factory(Namespace_ $namespace, string $rawRelative, string $relative, string $className, string $baseNamespaceSource, string $baseNamespaceTest, string $namespaceSource, string $namespaceTest, string $fullyQualifiedSource, string $fullyQualifiedTest): void
    {
        $classString = ClassString::factory($namespace, $rawRelative);

        self::assertSame($baseNamespaceSource, $classString->baseNamespace->source);
        self::assertSame($baseNamespaceTest, $classString->baseNamespace->test);
        self::assertSame($relative, $classString->relative);
        self::assertSame($className, $classString->className);
        self::assertSame($namespaceSource, $classString->namespace->source);
        self::assertSame($namespaceTest, $classString->namespace->test);
        self::assertSame($fullyQualifiedSource, $classString->fullyQualified->source);
        self::assertSame($fullyQualifiedTest, $classString->fullyQualified->test);
    }
}
