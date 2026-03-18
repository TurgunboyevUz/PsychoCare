<?php

namespace Filament\Admin\Resources\UserMoods\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Admin\Resources\UserMoods\UserMoodResource;
use Filament\Resources\Pages\EditRecord;

class EditUserMood extends EditRecord
{
    protected static string $resource = UserMoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
