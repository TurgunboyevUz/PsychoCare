<?php

namespace Filament\Admin\Resources\UserMoods\Pages;

use Filament\Actions\EditAction;
use Filament\Admin\Resources\UserMoods\UserMoodResource;
use Filament\Resources\Pages\ViewRecord;

class ViewUserMood extends ViewRecord
{
    protected static string $resource = UserMoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
