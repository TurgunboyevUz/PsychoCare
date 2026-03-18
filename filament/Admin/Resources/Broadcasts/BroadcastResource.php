<?php

namespace Filament\Admin\Resources\Broadcasts;

use App\Models\Broadcast;
use BackedEnum;
use Filament\Admin\Resources\Broadcasts\Pages\CreateBroadcast;
use Filament\Admin\Resources\Broadcasts\Pages\EditBroadcast;
use Filament\Admin\Resources\Broadcasts\Pages\ListBroadcasts;
use Filament\Admin\Resources\Broadcasts\Schemas\BroadcastForm;
use Filament\Admin\Resources\Broadcasts\Tables\BroadcastsTable;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BroadcastResource extends Resource
{
    protected static ?string $model = Broadcast::class;

    protected static ?string $label = 'xabarnoma';

    protected static ?string $pluralLabel = 'Xabarnomalar';

    protected static ?string $navigationLabel = 'Xabarnomalar';

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    public static function form(Schema $schema): Schema
    {
        return BroadcastForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BroadcastsTable::configure($table);
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
            'index' => ListBroadcasts::route('/'),
            'create' => CreateBroadcast::route('/create'),
            'edit' => EditBroadcast::route('/{record}/edit'),
        ];
    }
}
