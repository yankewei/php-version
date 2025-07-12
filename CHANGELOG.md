# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.1.0] - 2024-12-19

### Added
- `isLatestStable()` method to check if current version is the latest stable PHP version
- `LATEST_STABLE_VERSION` constant for storing the latest stable version
- Automated version update script (`scripts/update-version.php`)
- GitHub Actions workflow for daily version checks and automatic PR creation
- Comprehensive documentation in `docs/VERSION_UPDATE.md`

### Changed
- Optimized `isLatestStable()` method from dynamic API calls to static constant lookup
- Improved performance: test execution time reduced from ~4.5s to ~0.03s
- Enhanced error handling for version detection

### Technical Details
- The `isLatestStable()` method now uses a static constant instead of making HTTP requests
- GitHub Actions workflow runs daily at 9:00 UTC to check for new PHP versions
- When a new version is detected, an automated PR is created for manual review
- All existing functionality remains backward compatible

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

[1.1.0]: https://github.com/yankewei/php-version/releases/tag/v1.1.0
[1.0.0]: https://github.com/yankewei/php-version/releases/tag/v1.0.0


