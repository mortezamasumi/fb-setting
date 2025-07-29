<?php

namespace Mortezamasumi\FbSetting\Resources\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Mortezamasumi\FbSetting\Resources\FbSettingResource;

class ManageFbSettings extends ManageRecords
{
    protected static string $resource = FbSettingResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
