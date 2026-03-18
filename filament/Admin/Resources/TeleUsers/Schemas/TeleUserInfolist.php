<?php

namespace Filament\Admin\Resources\TeleUsers\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TeleUserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')->label('Telegram ID'),
                TextEntry::make('first_name')->label('Имя'),
                TextEntry::make('last_name')->label('Фамилия')
                    ->placeholder('-'),
                TextEntry::make('username')->label('Юзернейм')
                    ->placeholder('-'),
                TextEntry::make('timezone')->label('Часовой пояс')
                    ->numeric(),
            ]);
    }
}
