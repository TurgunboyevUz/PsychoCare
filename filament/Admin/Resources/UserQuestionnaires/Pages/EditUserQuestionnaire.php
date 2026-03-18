<?php

namespace Filament\Admin\Resources\UserQuestionnaires\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Admin\Resources\UserQuestionnaires\UserQuestionnaireResource;
use Filament\Resources\Pages\EditRecord;

class EditUserQuestionnaire extends EditRecord
{
    protected static string $resource = UserQuestionnaireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
