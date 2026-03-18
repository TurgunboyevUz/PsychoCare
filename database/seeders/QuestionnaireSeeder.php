<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireResult;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;

class QuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = json_decode(file_get_contents(storage_path('database/questionnaire.json')), true);

        foreach ($data as $item) {
            $category = Category::create([
                'name' => $item['name'],
                'description' => $item['description'],
            ]);

            foreach ($item['questionnaires'] as $questionnaire_item) {
                $questionnaire = Questionnaire::create([
                    'category_id' => $category->id,
                    'name' => $questionnaire_item['name'],
                    'type' => $questionnaire_item['type'],
                    'description' => $questionnaire_item['description'],
                    'info' => $questionnaire_item['scoring_logic']['info'],
                ]);

                foreach ($questionnaire_item['questions'] as $question_item) {
                    $question = Question::create([
                        'questionnaire_id' => $questionnaire->id,
                        'question' => $question_item['question'],
                        'sort' => $question_item['sort'],
                    ]);

                    foreach ($question_item['options'] as $option_item) {
                        QuestionOption::create([
                            'question_id' => $question->id,
                            'value' => $option_item['value'],
                            'score' => $option_item['score'],
                        ]);
                    }
                }

                foreach ($questionnaire_item['scoring_logic']['ranges'] ?? [] as $result_item) {
                    QuestionnaireResult::create([
                        'questionnaire_id' => $questionnaire->id,
                        'from' => $result_item['min'],
                        'to' => $result_item['max'],
                        'description' => $result_item['interpretation'],
                    ]);
                }
            }
        }
    }
}
