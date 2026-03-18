<?php

namespace Filament\Admin\Resources\Moods\Pages;

use Filament\Actions\CreateAction;
use Filament\Admin\Resources\Moods\MoodResource;
use Filament\Resources\Pages\ListRecords;

class ListMoods extends ListRecords
{
    protected static string $resource = MoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
