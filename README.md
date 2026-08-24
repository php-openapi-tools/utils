# utils

Shared utilities for [OpenAPI Tools](https://github.com/php-openapi-tools) code generators.

![Continuous Integration](https://github.com/php-openapi-tools/utils/workflows/Continuous%20Integration/badge.svg)
[![Latest Stable Version](https://poser.pugx.org/openapi-tools/utils/v/stable.png)](https://packagist.org/packages/openapi-tools/utils)
[![Total Downloads](https://poser.pugx.org/openapi-tools/utils/downloads.png)](https://packagist.org/packages/openapi-tools/utils/stats)
[![License](https://poser.pugx.org/openapi-tools/utils/license.png)](https://packagist.org/packages/openapi-tools/utils)

## Installation

To install via [Composer](https://getcomposer.org/), use the command below, it will automatically detect the latest version and bind it with `^`.

```
composer require openapi-tools/utils
```

## Components

| Class | Purpose |
| --- | --- |
| `Utils` | Sanitize strings into valid PHP class and namespace names |
| `Namespace_` | Source and test namespace pair |
| `ClassString` | Resolve relative class names against base namespaces |
| `File` | Generated file descriptor (path prefix, FQCN, contents) |
| `State` | Serialize and deserialize generator state to JSON |
| `State\Files` | Track generated file hashes by name |
| `State\File` | Single tracked file name and content hash |

## Usage

### Naming helpers

```php
use OpenAPITools\Utils\Utils;

Utils::className('namespace/sub/my-class'); // Namespace\Sub\MyClass
Utils::cleanUpString('bad{chars');         // bad_chars
Utils::fixKeyword('class');                // class_
Utils::dirname('\\Vendor\\Schema\\Foo');   // \Vendor\Schema
Utils::basename('\\Vendor\\Schema\\Foo');  // \Foo
```

### Class name resolution

```php
use OpenAPITools\Utils\ClassString;
use OpenAPITools\Utils\Namespace_;

$classString = ClassString::factory(
    new Namespace_('OpenAPITools\\Schema', 'OpenAPITools\\Tests\\Schema'),
    'Models\\User',
);

$classString->fullyQualified->source; // \OpenAPITools\Schema\Models\User
$classString->fullyQualified->test;   // \OpenAPITools\Tests\Schema\Models\User
$classString->className;              // User
```

### Generator state

```php
use OpenAPITools\Utils\State;

$state = State::initialize();
$state->specHash = 'abc123';
$state->generatedFiles->upsert('User.php', 'bef729dcdda9be9df5af3a1f3f50873e');

$json = State::serialize($state);
$state = State::deserialize($json);
```

### Generated files

```php
use OpenAPITools\Utils\File;

$file = new File(
    pathPrefix: '/tmp/generated',
    fqcn: '\\Vendor\\Schema\\User',
    contents: '<?php /* generated */',
    loadOnWrite: File::DO_LOAD_ON_WRITE,
);
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT)

Copyright (c) 2026 Cees-Jan Kiewiet

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
