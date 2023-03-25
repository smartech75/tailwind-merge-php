<?php

namespace YieldStudio\TailwindMerge\Rules;

class ArbitraryNumberRule extends ArbitraryValueRule
{
    protected ?string $parameter = 'number';

    protected function testValue(string $value): bool
    {
        return is_numeric($value);
    }
}