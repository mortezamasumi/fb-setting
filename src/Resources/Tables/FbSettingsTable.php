<?php

namespace Mortezamasumi\FbSetting\Resources\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class FbSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label(__('fb-setting::fb-setting.table.key'))
                    ->sortable()
                    ->searchable()
                    ->localeDigit('en'),
                TextColumn::make('value')
                    ->label(__('fb-setting::fb-setting.table.value'))
                    ->sortable()
                    ->searchable()
                    ->words(5),
                IconColumn::make('attributes')
                    ->label(__('fb-setting::fb-setting.table.attributes'))
                    ->trueIcon('heroicon-o-check')
                    ->falseIcon('')
                    ->color('success'),
                ToggleColumn::make('active')
                    ->label(__('fb-setting::fb-setting.table.active')),
            ])
            ->defaultSort('key', 'asc')
            ->recordActions([
                ReplicateAction::make()
                    ->schema([
                        TextInput::make('key')
                            ->label('fb-setting::fb-setting.form.key')
                            ->required()
                            ->unique(),
                    ])
                    ->modalWidth('lg')
                    ->beforeReplicaSaved(fn (Model $replica, array $data) => $replica->key = $data['key']),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
