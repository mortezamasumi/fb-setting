<?php

namespace Mortezamasumi\FbSetting\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed get(string $key, mixed $default = null, ?string $attrKey = null, array $values = [])
 *
 * @see \Mortezamasumi\FbSetting\FbSetting
 */
class FbSetting extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Mortezamasumi\FbSetting\FbSetting::class;
    }
}
