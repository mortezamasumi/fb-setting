<?php

namespace Mortezamasumi\FbSetting\Resources;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Mortezamasumi\FbSetting\Models\FbSetting;
use Mortezamasumi\FbSetting\Resources\Pages\ManageFbSettings;
use Mortezamasumi\FbSetting\Resources\Schemas\FbSettingForm;
use Mortezamasumi\FbSetting\Resources\Tables\FbSettingsTable;
use Mortezamasumi\Persian\Facades\Persian;

class FbSettingResource extends Resource
{
    protected static ?string $model = FbSetting::class;

    public static function getNavigationIcon(): string
    {
        return config('fbase.resource.settings.navigation.icon');
    }

    public static function getNavigationSort(): ?int
    {
        return config('fbase.resource.settings.navigation.sort');
    }

    public static function getNavigationLabel(): string
    {
        return __(config('fbase.resource.settings.navigation.label'));
    }

    public static function getNavigationGroup(): ?string
    {
        return __(config('fbase.resource.settings.navigation.group'));
    }

    public static function getModelLabel(): string
    {
        return __(config('fbase.resource.settings.navigation.model_label'));
    }

    public static function getPluralModelLabel(): string
    {
        return __(config('fbase.resource.settings.navigation.plural_model_label'));
    }

    public static function getNavigationParentItem(): ?string
    {
        return config('fbase.resource.settings.navigation.parent_item');
    }

    public static function getActiveNavigationIcon(): string|Htmlable|null
    {
        return config('fbase.resource.settings.navigation.active_icon') ?? static::getNavigationIcon();
    }

    public static function getNavigationBadge(): ?string
    {
        return config('fbase.resource.settings.navigation.show_count')
            ? Persian::digit(
                static::getModel()::where('active', true)->count(),
            )
            : null;
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
