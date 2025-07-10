<?php

namespace Yankewei\PHP;

class Version
{
    private function __construct(
        public private(set) readonly int $version_id
    ) {
    }

    public static function current(): self
    {
        return self::new(phpversion());
    }

    /**
     * string 8.1.1 from function phpversion()
     * int 80101 from PHP_VERSION_ID
     * 
     * @param string|int $version
     * @return self
     */
    public static function new(string|int $version): self
    {
        if (is_string($version)) {
            $version = array_map('intval', explode('.', $version));
            $version_id = $version[0] << 16 | $version[1] << 8 | $version[2];
        } else {
            $version_id = hexdec(strval($version));
        }

        return new self($version_id);
    }

    public function major(): int
    {
        return $this->version_id >> 16;
    }

    public function minor(): int
    {
        return $this->version_id >> 8 & 0xff;
    }

    public function patch(): int
    {
        return $this->version_id & 0xff;
    }

    /**
     * @param self $version
     * @return int -1: less than, 0: equal, 1: greater than
     */
    public function compare(self $version): int
    {
        return $this->version_id <=> $version->version_id;
    }
}
