<?php

namespace Filament\Admin\Resources\UserMoods\Pages;

use Filament\Actions\CreateAction;
use Filament\Admin\Resources\UserMoods\UserMoodResource;
use Filament\Resources\Pages\ListRecords;

class ListUserMoods extends ListRecords
{
    protected static string $resource = UserMoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
