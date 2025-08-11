<?php

namespace Mortezamasumi\FbSetting\Resources;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;
use Mortezamasumi\FbPersian\Facades\FbPersian;
use Mortezamasumi\FbSetting\Models\FbSetting;
use Mortezamasumi\FbSetting\Resources\Pages\ManageFbSettings;
use Mortezamasumi\FbSetting\Resources\Schemas\FbSettingForm;
use Mortezamasumi\FbSetting\Resources\Tables\FbSettingsTable;
use App;
use BackedEnum;
use UnitEnum;

class FbSettingResource extends Resource
{
    protected static ?string $model = FbSetting::class;

    public static function getModelLabel(): string
    {
        return __(config('fb-setting.navigation.model_label'));
    }

    public static function getPluralModelLabel(): string
    {
        return __(config('fb-setting.navigation.plural_model_label'));
    }

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __(config('fb-setting.navigation.group'));
    }

    public static function getNavigationParentItem(): ?string
    {
        return __(config('fb-setting.navigation.parent_item'));
    }

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return config('fb-setting.navigation.icon');
    }

    public static function getActiveNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return config('fb-setting.navigation.active_icon') ?? static::getNavigationIcon();
    }

    public static function getNavigationBadge(): ?string
    {
        return config('fb-setting.navigation.badge')
            ? Number::format(number: static::getModel()::count(), locale: App::getLocale())
            : null;
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return config('fb-setting.navigation.badge_tooltip');
    }

    public static function getNavigationSort(): ?int
    {
        return config('fb-setting.navigation.sort');
    }

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return $record->key;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['key', 'value', 'attributes'];
    }

    public static function form(Schema $schema): Schema
    {
        return FbSettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FbSettingsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageFbSettings::route('/'),
        ];
    }
}
