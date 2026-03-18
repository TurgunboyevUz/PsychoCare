<?php

namespace Filament\Admin\Resources\Moods;

use App\Models\Mood;
use BackedEnum;
use Filament\Admin\Resources\Moods\Pages\CreateMood;
use Filament\Admin\Resources\Moods\Pages\EditMood;
use Filament\Admin\Resources\Moods\Pages\ListMoods;
use Filament\Admin\Resources\Moods\Pages\ViewMood;
use Filament\Admin\Resources\Moods\Schemas\MoodForm;
use Filament\Admin\Resources\Moods\Schemas\MoodInfolist;
use Filament\Admin\Resources\Moods\Tables\MoodsTable;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class MoodResource extends Resource
{
    protected static ?string $model = Mood::class;

    protected static string|UnitEnum|null $navigationGroup = 'Kayfiyat';

    protected static ?string $label = 'kayfiyat';

    protected static ?string $pluralLabel = 'Kayfiyatlar';

    protected static ?string $navigationLabel = 'Ro\'yxat';

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBox;

    public static function form(Schema $schema): Schema
    {
        return MoodForm::configure($schema);
    }

    /*public static function infolist(Schema $schema): Schema
    {
        return MoodInfolist::configure($schema);
    }*/

    public static function table(Table $table): Table
    {
        return MoodsTable::configure($table);
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
            'index' => ListMoods::route('/'),
            'create' => CreateMood::route('/create'),
            'view' => ViewMood::route('/{record}'),
            'edit' => EditMood::route('/{record}/edit'),
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
