# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2024-12-19

### Added
- Initial release of PHP Version utility library
- `Version` class for handling PHP version operations
- Create version instances from string format (e.g., "8.1.1") or integer format (e.g., 80101)
- Get current PHP version with `Version::current()`
- Extract major, minor, and patch version components
- Compare versions with spaceship operator support
- Full test coverage with Pest testing framework
- PHPStan static analysis integration
- Comprehensive documentation and usage examples

### Requirements
- PHP ^8.4
- Composer for installation

[1.0.0]: https://github.com/yankewei/php-version/releases/tag/v1.0.0


