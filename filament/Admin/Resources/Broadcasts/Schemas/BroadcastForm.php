<?php

namespace Filament\Admin\Resources\Broadcasts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Validator;

class BroadcastForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Asosiy kontent')
                    ->columnSpanFull()
                    ->schema([
                        RichEditor::make('content')
                            ->label('Matn')
                            ->required(),

                        Grid::make()
                            ->columnSpan(1)
                            ->columns(1)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nomi')
                                    ->required(),

                                Select::make('media_type')
                                    ->label('Manba turi')
                                    ->options([
                                        'file' => 'Fayl',
                                        'url'  => 'Rasmga havola (URL)',
                                    ])
                                    ->default('file')
                                    ->native(false)
                                    ->preload()
                                    ->live(),

                                FileUpload::make('image')
                                    ->disk('public')
                                    ->hidden(fn($get) => $get('media_type') == 'url')
                                    ->disabled(fn($get) => $get('media_type') == 'url')
                                    ->directory('broadcast')
                                    ->label('Fayl'),

                                TextInput::make('image')
                                    ->label('Havola')
                                    ->placeholder('https://...')
                                    ->hidden(fn($get) => $get('media_type') == 'file' || empty($get('media_type')))
                                    ->disabled(fn($get) => $get('media_type') == 'file' || empty($get('media_type'))),

                                ToggleButtons::make('in_top')
                                    ->label('Rasmi joylashuvi')
                                    ->options([
                                        true => 'Matn ustida',
                                        false => 'Matn ostida'
                                    ])
                                    ->default(false)
                                    ->inline()
                            ]),
                    ]),

                DateTimePicker::make('scheduled_at')
                    ->label('Yuborish vaqti')
                    ->displayFormat('d/m/Y H:i')
                    ->native(false),

                ToggleButtons::make('notification')
                    ->label('Bildirishnoma (Ovozli)')
                    ->options([
                        1 => 'Yoqilgan',
                        0 => 'O‘chirilgan',
                    ])
                    ->colors([
                        1 => 'success',
                        0 => 'danger',
                    ])
                    ->default(1)
                    ->inline(),

                Repeater::make('buttons')
                    ->label('Tugmalar')
                    ->schema([
                        KeyValue::make('button')
                            ->label('Tugmalar')
                            ->keyLabel('Tugma matni')
                            ->valueLabel('Havola (URL)')
                            ->reorderable()
                            ->rules([
                                fn(): \Closure => function (string $attribute, $value, \Closure $fail) {
                                    foreach ($value as $button) {
                                        $validator = Validator::make(['val' => $button['value']], ['val' => 'url:https']);
                                        if ($validator->fails()) {
                                            $fail('"' . $button['key'] . '" tugmasi haqiqiy URL manzili (HTTPS) bo‘lishi kerak.');
                                        }
                                    }
                                },
                            ]),
                    ])
                    ->itemLabel('Qator №')
                    ->itemNumbers()
                    ->columnSpanFull(),
            ]);
    }
}