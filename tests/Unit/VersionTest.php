<?php

declare(strict_types=1);

use Yankewei\PHP\Version;

describe('new()', function (): void {
    it('creates version from string format', function (): void {
        $version = Version::new('8.1.1');

        expect($version->major())->toBe(8);
        expect($version->minor())->toBe(1);
        expect($version->patch())->toBe(1);
    });

    it('creates version from integer format', function (): void {
        $version = Version::new(80101);

        expect($version->major())->toBe(8);
        expect($version->minor())->toBe(1);
        expect($version->patch())->toBe(1);
    });

    it('handles single digit versions', function (): void {
        $version = Version::new('7.0.0');

        expect($version->major())->toBe(7);
        expect($version->minor())->toBe(0);
        expect($version->patch())->toBe(0);
    });

    it('handles double digit versions', function (): void {
        $version = Version::new('8.10.15');

        expect($version->major())->toBe(8);
        expect($version->minor())->toBe(10);
        expect($version->patch())->toBe(15);
    });

    it('handles zero versions', function (): void {
        $version = Version::new('0.0.0');

        expect($version->major())->toBe(0);
        expect($version->minor())->toBe(0);
        expect($version->patch())->toBe(0);
    });

    it('handles large version numbers', function (): void {
        $version = Version::new('255.255.255');

        expect($version->major())->toBe(255);
        expect($version->minor())->toBe(255);
        expect($version->patch())->toBe(255);
    });
});

describe('current()', function (): void {
    it('returns current PHP version', function (): void {
        $version = Version::current();

        expect($version)->toBeInstanceOf(Version::class);
        expect($version->major())->toBeGreaterThanOrEqual(7);
    });
});

describe('major()', function (): void {
    it('returns major version number', function (): void {
        $version = Version::new('8.1.1');

        expect($version->major())->toBe(8);
    });

    it('returns major version from integer input', function (): void {
        $version = Version::new(80101);

        expect($version->major())->toBe(8);
    });
});

describe('minor()', function (): void {
    it('returns minor version number', function (): void {
        $version = Version::new('8.1.1');

        expect($version->minor())->toBe(1);
    });

    it('returns minor version from integer input', function (): void {
        $version = Version::new(80101);

        expect($version->minor())->toBe(1);
    });

    it('returns zero for minor version', function (): void {
        $version = Version::new('8.0.1');

        expect($version->minor())->toBe(0);
    });
});

describe('patch()', function (): void {
    it('returns patch version number', function (): void {
        $version = Version::new('8.1.1');

        expect($version->patch())->toBe(1);
    });

    it('returns patch version from integer input', function (): void {
        $version = Version::new(80101);

        expect($version->patch())->toBe(1);
    });

    it('returns zero for patch version', function (): void {
        $version = Version::new('8.1.0');

        expect($version->patch())->toBe(0);
    });
});

describe('compare()', function (): void {
    it('returns -1 when version is less than other', function (): void {
        $version1 = Version::new('8.1.0');
        $version2 = Version::new('8.1.1');

        expect($version1->compare($version2))->toBe(-1);
    });

    it('returns 0 when versions are equal', function (): void {
        $version1 = Version::new('8.1.1');
        $version2 = Version::new('8.1.1');

        expect($version1->compare($version2))->toBe(0);
    });

    it('returns 1 when version is greater than other', function (): void {
        $version1 = Version::new('8.1.2');
        $version2 = Version::new('8.1.1');

        expect($version1->compare($version2))->toBe(1);
    });

    it('compares major versions correctly', function (): void {
        $version1 = Version::new('7.4.0');
        $version2 = Version::new('8.0.0');

        expect($version1->compare($version2))->toBe(-1);
        expect($version2->compare($version1))->toBe(1);
    });

    it('compares minor versions correctly', function (): void {
        $version1 = Version::new('8.0.0');
        $version2 = Version::new('8.1.0');

        expect($version1->compare($version2))->toBe(-1);
        expect($version2->compare($version1))->toBe(1);
    });

    it('compares patch versions correctly', function (): void {
        $version1 = Version::new('8.1.0');
        $version2 = Version::new('8.1.1');

        expect($version1->compare($version2))->toBe(-1);
        expect($version2->compare($version1))->toBe(1);
    });

    it('compares versions with different formats', function (): void {
        $version1 = Version::new('8.1.1');
        $version2 = Version::new(80101);

        expect($version1->compare($version2))->toBe(0);
    });
});

describe('isLatestStable()', function (): void {
    it('returns boolean value', function (): void {
        $version = Version::new('8.1.1');
        $result = $version->isLatestStable();

        expect($result)->toBeBool();
    });

    it('returns false for obviously outdated versions', function (): void {
        $version = Version::new('7.4.0');
        $result = $version->isLatestStable();

        expect($result)->toBe(false);
    });

    it('returns false for very old versions', function (): void {
        $version = Version::new('5.6.0');
        $result = $version->isLatestStable();

        expect($result)->toBe(false);
    });

    it('works with current PHP version', function (): void {
        $version = Version::current();
        $result = $version->isLatestStable();

        expect($result)->toBeBool();
    });
});

describe('edge cases', function (): void {
    it('handles maximum version numbers', function (): void {
        $version = Version::new('255.255.255');

        expect($version->major())->toBe(255);
        expect($version->minor())->toBe(255);
        expect($version->patch())->toBe(255);
    });

    it('handles minimum version numbers', function (): void {
        $version = Version::new('0.0.0');

        expect($version->major())->toBe(0);
        expect($version->minor())->toBe(0);
        expect($version->patch())->toBe(0);
    });

    it('handles mixed format comparisons', function (): void {
        $version1 = Version::new('8.1.1');
        $version2 = Version::new(80102);

        expect($version1->compare($version2))->toBe(-1);
        expect($version2->compare($version1))->toBe(1);
    });
});
