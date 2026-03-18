<?php

namespace Filament\Admin\Resources\UserQuestionnaires;

use App\Models\UserQuestionnaire;
use BackedEnum;
use Filament\Admin\Resources\UserQuestionnaires\Pages\CreateUserQuestionnaire;
use Filament\Admin\Resources\UserQuestionnaires\Pages\EditUserQuestionnaire;
use Filament\Admin\Resources\UserQuestionnaires\Pages\ListUserQuestionnaires;
use Filament\Admin\Resources\UserQuestionnaires\Pages\ViewUserQuestionnaire;
use Filament\Admin\Resources\UserQuestionnaires\Schemas\UserQuestionnaireForm;
use Filament\Admin\Resources\UserQuestionnaires\Schemas\UserQuestionnaireInfolist;
use Filament\Admin\Resources\UserQuestionnaires\Tables\UserQuestionnairesTable;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class UserQuestionnaireResource extends Resource
{
    protected static ?string $model = UserQuestionnaire::class;

    protected static string|UnitEnum|null $navigationGroup = 'Savollar';

    protected static ?string $label = 'natija';

    protected static ?string $pluralLabel = 'Statistika';

    protected static ?string $navigationLabel = 'Statistika';

    protected static ?int $navigationSort = 4;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheck;

    public static function form(Schema $schema): Schema
    {
        return UserQuestionnaireForm::configure($schema);
    }

    /*public static function infolist(Schema $schema): Schema
    {
        return UserQuestionnaireInfolist::configure($schema);
    }*/

    public static function table(Table $table): Table
    {
        return UserQuestionnairesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUserQuestionnaires::route('/'),
            'create' => CreateUserQuestionnaire::route('/create'),
            'view' => ViewUserQuestionnaire::route('/{record}'),
            'edit' => EditUserQuestionnaire::route('/{record}/edit'),
        ];
    }

    public static function getCreateAuthorizationResponse(): Response
    {
        return Response::deny();
    }

    public static function getDeleteAuthorizationResponse(Model $record): Response
    {
        return Response::deny();
    }

    public static function getEditAuthorizationResponse(Model $record): Response
    {
        return Response::deny();
    }
}
