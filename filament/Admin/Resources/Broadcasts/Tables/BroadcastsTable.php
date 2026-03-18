<?php
namespace Filament\Admin\Resources\Broadcasts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BroadcastsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nomi'),

                ImageColumn::make('image')
                    ->disk('public')
                    ->label('Rasmi')
                    ->placeholder('Rasm mavjud emas'),

                TextColumn::make('sent')
                    ->label('Yuborilgan'),

                TextColumn::make('failed')
                    ->label('Xatolik'),

                TextColumn::make('scheduled_at')
                    ->label('Yuborilish vaqti')
                    ->placeholder('Darhol'),

                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'pending'    => 'Kutilmoqda',
                        'processing' => 'Jarayonda',
                        'cancelled'  => 'Bekor qilingan',
                        'failed'     => 'Xatolik',
                        'completed'  => 'Yakunlangan',
                    })
                    ->color(fn($state) => match ($state) {
                        'pending'    => 'warning',
                        'processing' => 'warning',
                        'cancelled'  => 'danegr',
                        'failed'     => 'danger',
                        'completed'  => 'success'
                    })
                    ->badge(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
