<?php

use Yankewei\PHP\Version;

describe('Version', function () {
    describe('new()', function () {
        it('creates version from string format', function () {
            $version = Version::new('8.1.1');
            
            expect($version->major())->toBe(8);
            expect($version->minor())->toBe(1);
            expect($version->patch())->toBe(1);
        });

        it('creates version from integer format', function () {
            $version = Version::new(80101);
            
            expect($version->major())->toBe(8);
            expect($version->minor())->toBe(1);
            expect($version->patch())->toBe(1);
        });

        it('handles single digit versions', function () {
            $version = Version::new('7.0.0');
            
            expect($version->major())->toBe(7);
            expect($version->minor())->toBe(0);
            expect($version->patch())->toBe(0);
        });

        it('handles double digit versions', function () {
            $version = Version::new('8.10.15');
            
            expect($version->major())->toBe(8);
            expect($version->minor())->toBe(10);
            expect($version->patch())->toBe(15);
        });

        it('handles zero versions', function () {
            $version = Version::new('0.0.0');
            
            expect($version->major())->toBe(0);
            expect($version->minor())->toBe(0);
            expect($version->patch())->toBe(0);
        });

        it('handles large version numbers', function () {
            $version = Version::new('255.255.255');
            
            expect($version->major())->toBe(255);
            expect($version->minor())->toBe(255);
            expect($version->patch())->toBe(255);
        });
    });

    describe('current()', function () {
        it('returns current PHP version', function () {
            $version = Version::current();
            
            expect($version)->toBeInstanceOf(Version::class);
            expect($version->major())->toBeGreaterThanOrEqual(7);
        });
    });

    describe('major()', function () {
        it('returns major version number', function () {
            $version = Version::new('8.1.1');
            
            expect($version->major())->toBe(8);
        });

        it('returns major version from integer input', function () {
            $version = Version::new(80101);
            
            expect($version->major())->toBe(8);
        });
    });

    describe('minor()', function () {
        it('returns minor version number', function () {
            $version = Version::new('8.1.1');
            
            expect($version->minor())->toBe(1);
        });

        it('returns minor version from integer input', function () {
            $version = Version::new(80101);
            
            expect($version->minor())->toBe(1);
        });

        it('returns zero for minor version', function () {
            $version = Version::new('8.0.1');
            
            expect($version->minor())->toBe(0);
        });
    });

    describe('patch()', function () {
        it('returns patch version number', function () {
            $version = Version::new('8.1.1');
            
            expect($version->patch())->toBe(1);
        });

        it('returns patch version from integer input', function () {
            $version = Version::new(80101);
            
            expect($version->patch())->toBe(1);
        });

        it('returns zero for patch version', function () {
            $version = Version::new('8.1.0');
            
            expect($version->patch())->toBe(0);
        });
    });

    describe('compare()', function () {
        it('returns -1 when version is less than other', function () {
            $version1 = Version::new('8.1.0');
            $version2 = Version::new('8.1.1');
            
            expect($version1->compare($version2))->toBe(-1);
        });

        it('returns 0 when versions are equal', function () {
            $version1 = Version::new('8.1.1');
            $version2 = Version::new('8.1.1');
            
            expect($version1->compare($version2))->toBe(0);
        });

        it('returns 1 when version is greater than other', function () {
            $version1 = Version::new('8.1.2');
            $version2 = Version::new('8.1.1');
            
            expect($version1->compare($version2))->toBe(1);
        });

        it('compares major versions correctly', function () {
            $version1 = Version::new('7.4.0');
            $version2 = Version::new('8.0.0');
            
            expect($version1->compare($version2))->toBe(-1);
            expect($version2->compare($version1))->toBe(1);
        });

        it('compares minor versions correctly', function () {
            $version1 = Version::new('8.0.0');
            $version2 = Version::new('8.1.0');
            
            expect($version1->compare($version2))->toBe(-1);
            expect($version2->compare($version1))->toBe(1);
        });

        it('compares patch versions correctly', function () {
            $version1 = Version::new('8.1.0');
            $version2 = Version::new('8.1.1');
            
            expect($version1->compare($version2))->toBe(-1);
            expect($version2->compare($version1))->toBe(1);
        });

        it('compares versions with different formats', function () {
            $version1 = Version::new('8.1.1');
            $version2 = Version::new(80101);
            
            expect($version1->compare($version2))->toBe(0);
        });
    });

    describe('edge cases', function () {
        it('handles maximum version numbers', function () {
            $version = Version::new('255.255.255');
            
            expect($version->major())->toBe(255);
            expect($version->minor())->toBe(255);
            expect($version->patch())->toBe(255);
        });

        it('handles minimum version numbers', function () {
            $version = Version::new('0.0.0');
            
            expect($version->major())->toBe(0);
            expect($version->minor())->toBe(0);
            expect($version->patch())->toBe(0);
        });

        it('handles mixed format comparisons', function () {
            $version1 = Version::new('8.1.1');
            $version2 = Version::new(80102);
            
            expect($version1->compare($version2))->toBe(-1);
            expect($version2->compare($version1))->toBe(1);
        });
    });
});


