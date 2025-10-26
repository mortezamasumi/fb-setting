<?php

use Mortezamasumi\FbSetting\Facades\FbSetting;

if (! function_exists('__setting')) {
    function __setting(string $key, mixed $default = null, ?string $attrKey = null, array $values = []): string
    {
        return FbSetting::get($key, $default, $attrKey, $values);
    }
}
