<?php

namespace Filament\Admin\Resources\UserMoods;

use App\Models\UserMood;
use BackedEnum;
use Filament\Admin\Resources\UserMoods\Pages\CreateUserMood;
use Filament\Admin\Resources\UserMoods\Pages\EditUserMood;
use Filament\Admin\Resources\UserMoods\Pages\ListUserMoods;
use Filament\Admin\Resources\UserMoods\Pages\ViewUserMood;
use Filament\Admin\Resources\UserMoods\Schemas\UserMoodForm;
use Filament\Admin\Resources\UserMoods\Schemas\UserMoodInfolist;
use Filament\Admin\Resources\UserMoods\Tables\UserMoodsTable;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class UserMoodResource extends Resource
{
    protected static ?string $model = UserMood::class;

    protected static string|UnitEnum|null $navigationGroup = 'Kayfiyat';

    protected static ?string $label = 'natija';

    protected static ?string $pluralLabel = 'Natijalar';

    protected static ?string $navigationLabel = 'Kundalik';

    protected static ?int $navigationSort = 2;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendar;

    public static function form(Schema $schema): Schema
    {
        return UserMoodForm::configure($schema);
    }

    /*public static function infolist(Schema $schema): Schema
    {
        return UserMoodInfolist::configure($schema);
    }*/

    public static function table(Table $table): Table
    {
        return UserMoodsTable::configure($table);
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
            'index' => ListUserMoods::route('/'),
            'create' => CreateUserMood::route('/create'),
            'view' => ViewUserMood::route('/{record}'),
            'edit' => EditUserMood::route('/{record}/edit'),
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
}
