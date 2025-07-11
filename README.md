# PHP Version

[![Latest Version on Packagist](https://img.shields.io/packagist/v/yankewei/php-version.svg?style=flat-square)](https://packagist.org/packages/yankewei/php-version)
[![Tests](https://img.shields.io/github/actions/workflow/status/yankewei/php-version/ci.yml?branch=main&label=tests&style=flat-square)](https://github.com/yankewei/php-version/actions/workflows/ci.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/yankewei/php-version.svg?style=flat-square)](https://packagist.org/packages/yankewei/php-version)


## Installation

You can install the package via composer:

```bash
composer require yankewei/php-version
```

## Usage

```php
use Yankewei\PHP\Version;

// Create version from string
$version = Version::new('8.1.1');
echo $version->major(); // 8
echo $version->minor(); // 1
echo $version->patch(); // 1

// Create version from integer
$version = Version::new(80101);
echo $version->major(); // 8

// Get current PHP version
$current = Version::current();
echo $current->major(); // Current PHP major version

// Compare versions
$version1 = Version::new('8.1.0');
$version2 = Version::new('8.1.1');
$result = $version1->compare($version2); // -1 (less than)
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
