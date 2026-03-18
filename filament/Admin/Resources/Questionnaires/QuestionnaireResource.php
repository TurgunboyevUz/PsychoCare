<?php

namespace Filament\Admin\Resources\Questionnaires;

use App\Models\Questionnaire;
use BackedEnum;
use Filament\Admin\Resources\Questionnaires\Pages\CreateQuestionnaire;
use Filament\Admin\Resources\Questionnaires\Pages\EditQuestionnaire;
use Filament\Admin\Resources\Questionnaires\Pages\ListQuestionnaires;
use Filament\Admin\Resources\Questionnaires\Pages\ViewQuestionnaire;
use Filament\Admin\Resources\Questionnaires\RelationManagers\ResultsRelationManager;
use Filament\Admin\Resources\Questionnaires\Schemas\QuestionnaireForm;
use Filament\Admin\Resources\Questionnaires\Schemas\QuestionnaireInfolist;
use Filament\Admin\Resources\Questionnaires\Tables\QuestionnairesTable;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class QuestionnaireResource extends Resource
{
    protected static ?string $model = Questionnaire::class;

    protected static string|UnitEnum|null $navigationGroup = 'Savollar';

    protected static ?string $label = 'savol';

    protected static ?string $pluralLabel = 'Savollar';

    protected static ?string $navigationLabel = 'Savollar';

    protected static ?int $navigationSort = 2;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;

    public static function form(Schema $schema): Schema
    {
        return QuestionnaireForm::configure($schema);
    }

    /*public static function infolist(Schema $schema): Schema
    {
        return QuestionnaireInfolist::configure($schema);
    }*/

    public static function table(Table $table): Table
    {
        return QuestionnairesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ResultsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuestionnaires::route('/'),
            'create' => CreateQuestionnaire::route('/create'),
            'view' => ViewQuestionnaire::route('/{record}'),
            'edit' => EditQuestionnaire::route('/{record}/edit'),
        ];
    }
}
