<?php
namespace Bot\Handler;

use App\Models\Category;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\TeleUser;
use App\Models\UserQuestionnaire;
use Bot\Key\QuestionKeyboard;
use SergiX44\Nutgram\Nutgram;

class QuestionHandler extends Handler
{
    public function testing_disorders(Nutgram $bot)
    {
        TeleUser::where('user_id', $bot->chatId())
            ->first()
            ->questionnaires()
            ->where(function ($q) {
                $q->where('status', 'pending')->orWhere('status', 'processing');
            })
            ->update(['status' => 'cancelled']);

        $method = $bot->isCallbackQuery() ? 'editMessageText' : 'sendMessage';

        $method($bot, __('question.testing_disorders'), 'html', QuestionKeyboard::categoryList());
    }

    public function category(Nutgram $bot, $id)
    {
        TeleUser::where('user_id', $bot->chatId())
            ->first()
            ->questionnaires()
            ->where(function ($q) {
                $q->where('status', 'pending')->orWhere('status', 'processing');
            })
            ->update(['status' => 'cancelled']);

        $category = Category::find($id);

        editMessageText($bot, __('question.category', [
            'name'        => $category->name,
            'description' => $category->description,
        ]), 'html', QuestionKeyboard::testList($category));
    }

    public function prev_results(Nutgram $bot, $id)
    {
        $user           = TeleUser::where('user_id', $bot->chatId())->first();
        $questionnaire  = Questionnaire::find($id);
        $questionnaires = $user->questionnaires()->where('questionnaire_id', $id)->get();

        editMessageText($bot, __('question.prev_results', [
            'name' => $questionnaire->name,
        ]), 'html', QuestionKeyboard::prevResults($questionnaire, $questionnaires));
    }

    public function result(Nutgram $bot, $id)
    {
        $user_result = UserQuestionnaire::find($id);
        $questions   = Question::with([
            'options' => fn($q) => $q->whereIn('id', array_values($user_result->answers)),
        ])->whereIn('id', array_keys($user_result->answers))->get();

        $answer_list = '';
        foreach ($questions as $question) {
            $answer_list .= "\n\n" . __('question.result_item', [
                'question' => $question->question,
                'answer'   => $question->options->first()->value,
            ]);
        }

        editMessageText($bot, __('question.result_list', [
            'name'        => $user_result->questionnaire->name,
            'result_list' => trim($answer_list),
        ]), 'html', QuestionKeyboard::result($user_result->questionnaire, $id));
    }

    public function interpretation(Nutgram $bot, $id)
    {
        $user_result = UserQuestionnaire::find($id);

        editMessageText($bot, __('question.interpretation_of_result', [
            'name' => $user_result->questionnaire->name,
            'info' => $user_result->questionnaire->info,
        ]), 'html', QuestionKeyboard::interpretation($user_result->questionnaire));
    }
}
