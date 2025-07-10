<?php

namespace Yankewei\PHP;

use InvalidArgumentException;

class Version
{
    private function __construct(
        public private(set) readonly int $version_id
    ) {}

    public static function current(): self
    {
        return self::new(phpversion());
    }

    /**
     * string 8.1.1 from function phpversion()
     * int 80101 from PHP_VERSION_ID
     */
    public static function new(string|int $version): self
    {
        if (is_string($version)) {
            $version = array_map('intval', explode('.', $version));
            $version_id = $version[0] << 16 | $version[1] << 8 | $version[2];
        } else {
            $version_id = hexdec(strval($version));

            if (! is_int($version_id)) {
                throw new InvalidArgumentException('Invalid version');
            }
        }

        return new self($version_id);
    }

    public function major(): int
    {
        return $this->version_id >> 16;
    }

    public function minor(): int
    {
        return $this->version_id >> 8 & 0xFF;
    }

    public function patch(): int
    {
        return $this->version_id & 0xFF;
    }

    /**
     * @return int -1: less than, 0: equal, 1: greater than
     */
    public function compare(self $version): int
    {
        return $this->version_id <=> $version->version_id;
    }
}
