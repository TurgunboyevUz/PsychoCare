<?php

namespace Filament\Admin\Resources\Moods\Pages;

use Filament\Actions\EditAction;
use Filament\Admin\Resources\Moods\MoodResource;
use Filament\Resources\Pages\ViewRecord;

class ViewMood extends ViewRecord
{
    protected static string $resource = MoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
