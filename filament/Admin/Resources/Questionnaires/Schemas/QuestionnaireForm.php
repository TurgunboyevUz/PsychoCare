<?php

namespace Filament\Admin\Resources\Questionnaires\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class QuestionnaireForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(1)->columnSpan(1)->schema([
                    Select::make('category_id')
                        ->label('Kategoriya')
                        ->options(Category::all()->pluck('name', 'id'))
                        ->preload()
                        ->searchable()
                        ->required(),

                    TextInput::make('name')
                        ->label('Test nomi')
                        ->required(),

                    Select::make('type')
                        ->label('Turi')
                        ->options([
                            'yn' => 'Ha/Yo‘q',
                            'text' => 'Ko‘p variantli (Multi-javob)',
                        ])
                        ->required()
                        ->live()
                        ->native(false),
                ]),

                Grid::make(1)->columnSpan(1)->schema([
                    Textarea::make('description')
                        ->label('Tavsif')
                        ->columnSpan(1),

                    TextArea::make('info')
                        ->label('Ma’lumot (Info)')
                        ->columnSpan(1),
                ]),

                Repeater::make('questions')
                    ->label('Savollar')
                    ->columnSpanFull()
                    ->relationship()
                    ->schema([
                        TextInput::make('question')
                            ->label('Savol matni')
                            ->required()
                            ->columnSpan(1),

                        Repeater::make('options')
                            ->label('Variantlar')
                            ->relationship()
                            ->table([
                                TableColumn::make('Javob')->markAsRequired(),
                                TableColumn::make('Ball')->markAsRequired(),
                            ])
                            ->schema([
                                TextInput::make('value')->label('Javob')->columnSpan(1),
                                TextInput::make('score')->label('Ball')->columnSpan(1)->numeric(),
                            ])
                            ->defaultItems(fn (Get $get) => $get('../../type') == 'yn' ? 2 : 1)
                            ->live(),
                    ])
                    ->orderColumn()
                    ->cloneable(),
            ]);
    }
}