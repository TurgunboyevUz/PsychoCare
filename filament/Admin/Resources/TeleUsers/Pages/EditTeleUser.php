<?php

namespace Filament\Admin\Resources\TeleUsers\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Admin\Resources\TeleUsers\TeleUserResource;
use Filament\Resources\Pages\EditRecord;

class EditTeleUser extends EditRecord
{
    protected static string $resource = TeleUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
