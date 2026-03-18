<?php

namespace Filament\Admin\Resources\UserQuestionnaires\Pages;

use Filament\Actions\EditAction;
use Filament\Admin\Resources\UserQuestionnaires\UserQuestionnaireResource;
use Filament\Resources\Pages\ViewRecord;

class ViewUserQuestionnaire extends ViewRecord
{
    protected static string $resource = UserQuestionnaireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
