<?php

namespace Filament\Admin\Resources\Categories\Pages;

use Filament\Actions\EditAction;
use Filament\Admin\Resources\Categories\CategoryResource;
use Filament\Resources\Pages\ViewRecord;

class ViewCategory extends ViewRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
