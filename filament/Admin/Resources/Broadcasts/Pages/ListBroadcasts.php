<?php

namespace Filament\Admin\Resources\Broadcasts\Pages;

use Filament\Actions\CreateAction;
use Filament\Admin\Resources\Broadcasts\BroadcastResource;
use Filament\Resources\Pages\ListRecords;

class ListBroadcasts extends ListRecords
{
    protected static string $resource = BroadcastResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
