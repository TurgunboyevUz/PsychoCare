<?php

namespace Filament\Admin\Resources\UserQuestionnaires\Pages;

use Filament\Actions\CreateAction;
use Filament\Admin\Resources\UserQuestionnaires\UserQuestionnaireResource;
use Filament\Resources\Pages\ListRecords;

class ListUserQuestionnaires extends ListRecords
{
    protected static string $resource = UserQuestionnaireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
