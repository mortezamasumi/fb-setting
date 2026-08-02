<?php

use Mortezamasumi\FbSetting\Facades\FbSetting;

if (! function_exists('__fb_setting')) {
    /**
     * @param  array<string, string>  $values
     */
    function __fb_setting(string $key, mixed $default = null, ?string $attrKey = null, array $values = []): mixed
    {
        return FbSetting::get($key, $default, $attrKey, $values);
    }
}
