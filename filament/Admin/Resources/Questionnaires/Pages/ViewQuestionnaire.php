<?php

namespace Filament\Admin\Resources\Questionnaires\Pages;

use Filament\Actions\EditAction;
use Filament\Admin\Resources\Questionnaires\QuestionnaireResource;
use Filament\Resources\Pages\ViewRecord;

class ViewQuestionnaire extends ViewRecord
{
    protected static string $resource = QuestionnaireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
