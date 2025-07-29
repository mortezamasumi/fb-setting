<?php

namespace Mortezamasumi\FbSetting\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mortezamasumi\FbSetting\FbSetting
 */
class FbSetting extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Mortezamasumi\FbSetting\FbSetting::class;
    }
}
