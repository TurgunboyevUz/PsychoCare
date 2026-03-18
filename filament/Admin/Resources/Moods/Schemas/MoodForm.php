<?php

namespace Filament\Admin\Resources\Moods\Schemas;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class MoodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(1)->columnSpan(1)->schema([
                    TextInput::make('number_label')
                        ->label('Tugmada (raqam)'),
                    TextInput::make('number_label')
                        ->label('Tugmada (emoji)'),
                ]),

                Grid::make(1)->columnSpan(1)->schema([
                    TextInput::make('value')
                        ->label('Ball')
                        ->required()
                        ->numeric(),
                    MarkdownEditor::make('description')
                        ->label('Tavsif')
                        ->required(),
                ]),
            ]);
    }
}
