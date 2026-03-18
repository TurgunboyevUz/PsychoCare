<?php

namespace Filament\Admin\Resources\Moods\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Admin\Resources\Moods\MoodResource;
use Filament\Resources\Pages\EditRecord;

class EditMood extends EditRecord
{
    protected static string $resource = MoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
