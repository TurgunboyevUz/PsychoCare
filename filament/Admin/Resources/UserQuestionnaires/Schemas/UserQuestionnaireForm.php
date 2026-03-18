<?php

namespace Filament\Admin\Resources\UserQuestionnaires\Schemas;

use App\Models\Question;
use App\Models\QuestionnaireResult;
use Carbon\Carbon;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class UserQuestionnaireForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('questionnaire_id')
                    ->label('Test')
                    ->relationship('questionnaire', 'name')
                    ->reactive()
                    ->required(),

                TextInput::make('first_name')
                    ->label('Ism, familiya')
                    ->required()
                    ->formatStateUsing(function (Model $record) {
                        return $record->user->first_name;
                    }),

                TextInput::make('overall_score')
                    ->label('Ball'),

                TextInput::make('session_interval')
                    ->label('Davomiyligi')
                    ->formatStateUsing(fn ($state) => gmdate('H:i:s', $state)),

                TextInput::make('description')
                    ->label('Interpretatsiyasi')
                    ->formatStateUsing(function (Model $record) {
                        $score = $record->overall_score;
                        $result = QuestionnaireResult::where('from', '<=', $score)
                            ->where('to', '>=', $score)
                            ->where('questionnaire_id', $record->questionnaire_id)
                            ->first();

                        return $result->description;
                    }),

                TextInput::make('created_at')
                    ->label('Yaratilgan vaqti')
                    ->formatStateUsing(fn ($state) => Carbon::parse($state)->format('d/m/Y H:i')),

                Group::make()
                    ->relationship('questionnaire')
                    ->columnSpanFull()
                    ->schema(function (callable $get, Model $record) {
                        $questionnaireId = $get('questionnaire_id');

                        if (! $questionnaireId) {
                            return [];
                        }

                        $questions = Question::where('questionnaire_id', $questionnaireId)
                            ->orderBy('sort')
                            ->get();

                        return $questions->map(function ($question) use ($record) {
                            $options = $question->options()
                                ->pluck('value', 'id')
                                ->toArray();

                            return Fieldset::make($question->question)
                                ->schema([
                                    Radio::make("answers.{$question->id}")
                                        ->options($options)
                                        ->default($record->answers[$question->id])
                                        ->required(),
                                ]);
                        })->toArray();
                    }),
            ]);
    }
}
