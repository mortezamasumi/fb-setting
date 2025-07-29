<?php

namespace Mortezamasumi\FbSetting;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Mortezamasumi\FbSetting\Commands\FbSettingCommand;
use Mortezamasumi\FbSetting\Testing\TestsFbSetting;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FbSettingServiceProvider extends PackageServiceProvider
{
    public static string $name = 'fb-setting';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            // ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishMigrations()
                    ->askToRunMigrations();
            })
            ->hasMigrations($this->getMigrations())
            ->hasTranslations();
    }

    public function packageBooted(): void
    {
        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__.'/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/fb-setting/{$file->getFilename()}"),
                ], 'fb-setting-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsFbSetting);
    }

    // /**
    //  * @return array<class-string>
    //  */
    // protected function getCommands(): array
    // {
    //     return [
    //         InstallCommand::class,
    //     ];
    // }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_fb_settings_table',
        ];
    }
}
