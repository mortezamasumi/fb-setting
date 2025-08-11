<?php

namespace Mortezamasumi\FbSetting;

use App\Policies\FbSettingPolicy;
use Illuminate\Support\Facades\Gate;
use Livewire\Features\SupportTesting\Testable;
use Mortezamasumi\FbSetting\Models\FbSetting;
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
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishMigrations();
            })
            ->hasConfigFile()
            ->hasMigrations($this->getMigrations())
            ->hasTranslations();
    }

    public function packageBooted(): void
    {
        Gate::policy(FbSetting::class, FbSettingPolicy::class);

        Testable::mixin(new TestsFbSetting);
    }

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
