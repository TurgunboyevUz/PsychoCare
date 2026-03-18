<?php

namespace Filament\Admin\Resources\Questionnaires\RelationManagers;

use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ResultsRelationManager extends RelationManager
{
    protected static ?string $title = 'Natijalar interpretatsiyasi';

    protected static ?string $label = 'natijalar interpretatsiyasi';

    protected static ?string $pluralLabel = 'natijalar interpretatsiyasi';

    protected static string|BackedEnum|null $icon = Heroicon::OutlinedInformationCircle;

    protected static string $relationship = 'results';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(1)->columnSpan(1)->schema([
                    TextInput::make('from')
                        ->label('...balldan')
                        ->required()
                        ->numeric()
                        ->default(1),
                    TextInput::make('to')
                        ->label('...ballgacha')
                        ->required()
                        ->numeric()
                        ->default(1),
                ]),
                Textarea::make('description')
                    ->label('Tavsif')
                    ->columnSpan(1)
                    ->rows(5),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('from')
                    ->label('...balldan')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('to')
                    ->label('...balgacha')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Tavsif')
                    ->limit(20),
                TextColumn::make('created_at')
                    ->label('Yaratilgan vaqti')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Обновлено в')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
