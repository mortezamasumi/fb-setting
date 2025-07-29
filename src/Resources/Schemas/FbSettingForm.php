<?php

namespace Mortezamasumi\FbSetting\Resources\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FbSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->label(__('fb-setting::fb-setting.form.key'))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->extraAlpineAttributes(['dir' => 'ltr']),
                Textarea::make('value')
                    ->label(__('fb-setting::fb-setting.form.value'))
                    ->requiredWithout('attributes')
                    ->maxLength(2048)
                    ->rows(2),
                Repeater::make('attributes')
                    ->label(__('fb-setting::fb-setting.form.attributes'))
                    ->requiredWithout('value')
                    ->schema([
                        TextInput::make('key')
                            ->label(__('fb-setting::fb-setting.form.key'))
                            ->maxLength(255),
                        TextInput::make('value')
                            ->label(__('fb-setting::fb-setting.form.value'))
                            ->maxLength(255),
                    ])
                    ->default([])
                    ->columns(2),
            ])
            ->columns(1);
    }
}
