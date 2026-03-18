<?php
namespace Bot\Key;

use App\Models\Category;
use App\Models\Question;
use App\Models\Questionnaire;

class QuestionKeyboard
{
    public static function categoryList()
    {
        $keyboard   = [];
        $categories = Category::all();

        foreach ($categories as $category) {
            $keyboard[] = ['text' => $category->name, 'callback_data' => 'category:' . $category->id];
        }

        $keyboard[] = ['text' => __('button.home'), 'callback_data' => 'home'];

        return inlineKeyboard($keyboard);
    }

    public static function testList(Category $category)
    {
        $keyboard = [];

        foreach ($category->questionnaires as $questionnaire) {
            $keyboard[] = ['text' => $questionnaire->name, 'callback_data' => 'test:' . $questionnaire->id];
        }

        $keyboard[] = ['text' => __('button.back_to_test'), 'callback_data' => 'testing_disorders'];
        $keyboard[] = ['text' => __('button.home'), 'callback_data' => 'home'];

        return inlineKeyboard($keyboard);
    }

    public static function questionOption(Questionnaire $questionnaire, Question $question, $has_finished_records = false)
    {
        $keyboard      = [];
        $number_labels = ['1️⃣', '2️⃣', '3️⃣', '4️⃣', '5️⃣', '6️⃣', '7️⃣', '8️⃣', '9️⃣'];

        foreach ($question->options as $key => $option) {
            $keyboard[] = ['text' => $number_labels[$key], 'callback_data' => 'answer:' . $question->id . ':' . $option->id];
        }

        $keyboard = array_chunk($keyboard, $question->options->count());
        if ($has_finished_records) {
            $keyboard[] = ['text' => __('button.prev_results'), 'callback_data' => 'prev_results:' . $questionnaire->id];
        }
        $keyboard[] = ['text' => __('button.finish_and_back'), 'callback_data' => 'category:' . $questionnaire->category_id];

        return inlineKeyboard($keyboard);
    }

    public static function questionYN(Questionnaire $questionnaire, Question $question, $has_finished_records = false)
    {
        $keyboard = [];

        foreach ($question->options as $option) {
            $keyboard[] = ['text' => $option->value, 'callback_data' => 'answer:' . $question->id . ':' . $option->id];
        }

        $keyboard = array_chunk($keyboard, 2);
        if ($has_finished_records) {
            $keyboard[] = ['text' => __('button.prev_results'), 'callback_data' => 'prev_results:' . $questionnaire->id];
        }
        $keyboard[] = ['text' => __('button.finish_and_back'), 'callback_data' => 'category:' . $questionnaire->category_id];

        return inlineKeyboard($keyboard);
    }

    public static function question(Questionnaire $questionnaire, Question $question, $has_finished_records = false)
    {
        return match ($questionnaire->type) {
            'yn'   => self::questionYN($questionnaire, $question, $has_finished_records),
            'text' => self::questionOption($questionnaire, $question, $has_finished_records)
        };
    }

    public static function endAction(Questionnaire $questionnaire)
    {
        $category = $questionnaire->category;

        return inlineKeyboard([
            ['text' => __('button.prev_results'), 'callback_data' => 'prev_results:' . $questionnaire->id],
            ['text' => __('button.to_category', ['name' => $category->name]), 'callback_data' => 'category:' . $category->id],
            ['text' => __('button.finish_and_back'), 'callback_data' => 'testing_disorders'],
        ]);
    }

    public static function prevResults($questionnaire, $questionnaires)
    {
        $keyboard = [];

        foreach ($questionnaires as $user_result) {
            $date       = $user_result->created_at->format('d.m.Y') . ' в ' . $user_result->created_at->format('H:i');
            $keyboard[] = ['text' => $date . ' - ' . $user_result->overall_score . ' баллов', 'callback_data' => 'result:' . $user_result->id];
        }

        $keyboard[] = ['text' => __('button.back_to_test'), 'callback_data' => 'test:' . $questionnaire->id];
        $keyboard[] = ['text' => __('button.finish_and_back'), 'callback_data' => 'category:' . $questionnaire->category->id];

        return inlineKeyboard($keyboard);
    }

    public static function result($questionnaire, $result_id)
    {
        return inlineKeyboard([
            ['text' => __('button.interpretation_of_results'), 'callback_data' => 'interpretation:' . $result_id],
            ['text' => __('button.prev_results'), 'callback_data' => 'prev_results:' . $questionnaire->id],
            ['text' => __('button.back_to_test'), 'callback_data' => 'test:' . $questionnaire->id],
            ['text' => __('button.finish_and_back'), 'callback_data' => 'category:' . $questionnaire->category->id],
        ]);
    }

    public static function interpretation($questionnaire)
    {
        return inlineKeyboard([
            ['text' => __('button.prev_results'), 'callback_data' => 'prev_results:' . $questionnaire->id],
            ['text' => __('button.back_to_test'), 'callback_data' => 'test:' . $questionnaire->id],
            ['text' => __('button.finish_and_back'), 'callback_data' => 'category:' . $questionnaire->category->id],
        ]);
    }
}
