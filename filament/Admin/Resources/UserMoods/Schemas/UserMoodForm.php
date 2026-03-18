<?php

namespace Filament\Admin\Resources\UserMoods\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserMoodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tele_user_id')
                    ->tel()
                    ->required()
                    ->numeric(),
                TextInput::make('mood_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
