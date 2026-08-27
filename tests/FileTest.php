<?php

declare(strict_types=1);

namespace OpenAPITools\Tests\Utils;

use OpenAPITools\Utils\File;
use PhpParser\Node\Stmt\Nop;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use WyriHaximus\TestUtilities\TestCase;

final class FileTest extends TestCase
{
    /** @return iterable<array<bool>> */
    public static function loadOnWriteDataProvider(): iterable
    {
        yield [File::DO_LOAD_ON_WRITE];
        yield [File::DO_NOT_LOAD_ON_WRITE];
    }

    #[Test]
    #[DataProvider('loadOnWriteDataProvider')]
    public function construct(bool $loadOnWrite): void
    {
        $file = new File(
            pathPrefix: '/tmp/generated',
            fqcn: '\\Vendor\\Schema\\User',
            contents: '<?php /* generated */',
            loadOnWrite: $loadOnWrite,
        );

        self::assertSame('/tmp/generated', $file->pathPrefix);
        self::assertSame('\\Vendor\\Schema\\User', $file->fqcn);
        self::assertSame('<?php /* generated */', $file->contents);
        self::assertSame($loadOnWrite, $file->loadOnWrite);
    }

    #[Test]
    public function constructWithNodeContents(): void
    {
        $contents = new Nop();

        $file = new File(
            pathPrefix: '/tmp/generated',
            fqcn: '\\Vendor\\Schema\\User',
            contents: $contents,
            loadOnWrite: File::DO_NOT_LOAD_ON_WRITE,
        );

        self::assertSame($contents, $file->contents);
    }
}
