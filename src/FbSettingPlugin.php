<?php

namespace Mortezamasumi\FbSetting;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Mortezamasumi\FbSetting\Resources\FbSettingResource;

class FbSettingPlugin implements Plugin
{
    public function getId(): string
    {
        return 'fb-setting';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            FbSettingResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
