<?php

namespace Filament\Admin\Resources\Questionnaires\Pages;

use Filament\Actions\CreateAction;
use Filament\Admin\Resources\Questionnaires\QuestionnaireResource;
use Filament\Resources\Pages\ListRecords;

class ListQuestionnaires extends ListRecords
{
    protected static string $resource = QuestionnaireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
