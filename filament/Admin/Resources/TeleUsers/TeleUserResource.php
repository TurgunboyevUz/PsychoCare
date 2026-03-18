<?php
namespace Filament\Admin\Resources\TeleUsers;

use BackedEnum;
use Filament\Admin\Resources\TeleUsers\Pages\CreateTeleUser;
use Filament\Admin\Resources\TeleUsers\Pages\EditTeleUser;
use Filament\Admin\Resources\TeleUsers\Pages\ListTeleUsers;
use Filament\Admin\Resources\TeleUsers\Pages\ViewTeleUser;
use Filament\Admin\Resources\TeleUsers\Schemas\TeleUserForm;
use Filament\Admin\Resources\TeleUsers\Schemas\TeleUserInfolist;
use Filament\Admin\Resources\TeleUsers\Tables\TeleUsersTable;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class TeleUserResource extends Resource
{
    protected static string|UnitEnum|null $navigationGroup = 'Foydalanuvchilar';

    protected static ?string $label = 'foydalanuvchi';

    protected static ?string $pluralLabel = 'Foydalanuvchilar';

    protected static ?string $navigationLabel = 'Foydalanuvchilar';

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPaperAirplane;

    public static function form(Schema $schema): Schema
    {
        return TeleUserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TeleUserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TeleUsersTable::configure($table);
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
            'index'  => ListTeleUsers::route('/'),
            'create' => CreateTeleUser::route('/create'),
            'view'   => ViewTeleUser::route('/{record}'),
            'edit'   => EditTeleUser::route('/{record}/edit'),
        ];
    }

    public static function getCreateAuthorizationResponse(): Response
    {
        return Response::deny();
    }

    public static function getEditAuthorizationResponse(Model $record): Response
    {
        return Response::deny();
    }
}
