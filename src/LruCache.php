<?php

namespace YieldStudio\TailwindMerge;

class LruCache
{

    private array $cache = [];

    private array $previousCache = [];

    private int $cacheSize = 0;

    public function __construct(public readonly int $maxCacheSize)
    {
    }

    public function get(string $key)
    {
        if (array_key_exists($key, $this->cache) && $value = $this->cache[$key]) {
            return $value;
        }

        if (array_key_exists($key, $this->previousCache) && $value = $this->previousCache[$key]) {
            $this->update($key, $value);
            return $value;
        }

        return null;
    }

    public function set(string $key, $value): static
    {
        if (array_key_exists($key, $this->cache)) {
            $this->cache[$key] = $value;
        } else {
            $this->update($key, $value);
        }

        return $this;
    }

    private function update(string $key, $value): void
    {
        $this->cache[$key] = $value;
        $this->cacheSize++;

        if ($this->cacheSize > $this->maxCacheSize) {
            $this->cacheSize = 0;
            $this->previousCache = $this->cache;
            $this->cache = [];
        }
    }

}