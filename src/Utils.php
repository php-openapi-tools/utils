<?php

declare(strict_types=1);

namespace OpenAPITools\Utils;

use Jawira\CaseConverter\Convert;

use function array_keys;
use function array_map;
use function basename;
use function count;
use function dirname;
use function explode;
use function implode;
use function in_array;
use function str_replace;
use function strtolower;
use function trim;

final class Utils
{
    private const KEYWORD_COMPARISON     = false;
    public const RESERVED_KEYWORDS       = ['__halt_compiler', 'abstract', 'and', 'array', 'as', 'break', 'callable', 'case', 'catch', 'class', 'clone', 'const', 'continue', 'declare', 'default', 'die', 'do', 'echo', 'else', 'elseif', 'empty', 'enddeclare', 'endfor', 'endforeach', 'endif', 'endswitch', 'endwhile', 'eval', 'exit', 'extends', 'final', 'for', 'foreach', 'function', 'global', 'goto', 'if', 'implements', 'include', 'include_once', 'instanceof', 'insteadof', 'interface', 'isset', 'list', 'namespace', 'new', 'or', 'print', 'private', 'protected', 'public', 'require', 'require_once', 'return', 'static', 'switch', 'throw', 'trait', 'try', 'unset', 'use', 'var', 'while', 'xor', 'self', 'parent', 'object', 'int', 'float', 'string', 'true', 'false', 'null', 'void', 'iterable', 'mixed', 'never'];
    public const CLASS_NAME_REPLACE      = ['{' => ' ', '}' => ' ', '-' => '_', '$' => '_', '+' => '_', '*' => '_', '.' => '_', ';' => '_', '=' => '_', ' ' => '_'];
    public const CLEAN_UP_STRING_REPLACE = ['{' => ' ', '}' => ' ', '-' => '_', '$' => '_', '+' => '_', '*' => '_', '.' => '_', ';' => '_', '=' => '_', ' ' => '_', '/' => '_', '\\' => '_'];

    public static function cleanUpString(string $string): string
    {
        return self::fixKeyword(
            str_replace(
                array_keys(self::CLEAN_UP_STRING_REPLACE),
                self::CLEAN_UP_STRING_REPLACE,
                $string,
            ),
        );
    }

    public static function className(string $className): string
    {
        $className = str_replace(
            array_keys(self::CLASS_NAME_REPLACE),
            self::CLASS_NAME_REPLACE,
            $className,
        );

        $className = implode(
            '\\',
            array_map(
                static fn (string $chunk): string => self::fixKeyword(
                    (new Convert($chunk))->toPascal(),
                ),
                explode(
                    '\\',
                    $className,
                ),
            ),
        );

        return trim(self::cleanUpNamespace(self::fixKeyword($className)), '\\');
    }

    public static function cleanUpNamespace(string $namespace): string
    {
        do {
            $previousNamespace = $namespace;
            $namespace         = str_replace('/', '\\', $namespace);
            $namespace         = str_replace('\\\\', '\\', $namespace);
        } while ($previousNamespace !== $namespace);

        $namespace = trim($namespace, '\\');

        return '\\' . $namespace;
    }

    public static function fqcn(string $fqcn): string
    {
        return str_replace('/', '\\', $fqcn);
    }

    public static function dirname(string $fqcn): string
    {
        $fqcn = str_replace('\\', '/', $fqcn);

        return trim(self::cleanUpNamespace(dirname($fqcn)), '\\');
    }

    public static function basename(string $fqcn): string
    {
        $fqcn = str_replace('\\', '/', $fqcn);

        return trim(self::cleanUpNamespace(basename($fqcn)), '\\');
    }

    public static function fixKeyword(string $name): string
    {
        $name     = self::fqcn($name);
        $nameBoom = explode('\\', $name);

        /** @phpstan-ignore-next-line */
        return $name . (in_array(
            strtolower($nameBoom[count($nameBoom) - 1]),
            self::RESERVED_KEYWORDS,
            self::KEYWORD_COMPARISON,
        ) ? '_' : '');
    }
}
