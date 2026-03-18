<?php

namespace Filament\Admin\Resources\TeleUsers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TeleUserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required(),
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name'),
                TextInput::make('username'),
                Select::make('mood_style')
                    ->options(['number' => 'Number', 'emoji' => 'Emoji'])
                    ->default('number')
                    ->required(),
                TextInput::make('timezone')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('is_admin')
                    ->required(),
            ]);
    }
}
