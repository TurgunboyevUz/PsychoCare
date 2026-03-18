<?php

namespace Filament\Admin\Resources\TeleUsers\Pages;

use Filament\Actions\CreateAction;
use Filament\Admin\Resources\TeleUsers\TeleUserResource;
use Filament\Resources\Pages\ListRecords;

class ListTeleUsers extends ListRecords
{
    protected static string $resource = TeleUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
