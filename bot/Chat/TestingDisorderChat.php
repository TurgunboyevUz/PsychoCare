<?php
namespace Bot\Chat;

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireResult;
use App\Models\QuestionOption;
use App\Models\TeleUser;
use App\Models\UserQuestionnaire;
use Bot\Key\QuestionKeyboard;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class TestingDisorderChat extends Conversation
{
    public float $last_question_answered_at;

    public Questionnaire $questionnaire;

    public Question $question;

    public UserQuestionnaire $user_questionnaire;

    public int $count;

    public $has_finished_results;

    protected function getSerializableAttributes(): array
    {
        return [
            'last_question_answered_at' => $this->last_question_answered_at,
            'questionnaire'             => $this->questionnaire,
            'question'                  => $this->question,
            'count'                     => $this->count,
            'user_questionnaire'        => $this->user_questionnaire,
            'has_finished_results'      => $this->has_finished_results,
        ];
    }

    protected function generateOptionList($type, $options)
    {
        $option_list = '';

        if ($type != 'yn') {
            foreach ($options as $key => $option) {
                $option_list .= "\n" . ($key + 1) . '. ' . $option->value;
            }
        }

        return $option_list;
    }

    public function start(Nutgram $bot, $id)
    {
        $user          = TeleUser::where('user_id', $bot->chatId())->first();
        $questionnaire = Questionnaire::with(['category', 'questions.options',
            'user_questionnaires' => fn($q) => $q->where('tele_user_id', $user->id),
        ])->find($id);

        $question = $questionnaire->questions()->with('options')->get()->first();

        $this->questionnaire             = $questionnaire;
        $this->question                  = $question;
        $this->count                     = $questionnaire->questions()->count();
        $this->last_question_answered_at = microtime(true);
        $this->has_finished_results      = ! $questionnaire->user_questionnaires->isEmpty();
        $this->user_questionnaire        = $user->questionnaires()->create([
            'questionnaire_id' => $questionnaire->id,
            'session_interval' => 0,
            'answers'          => [],
        ]);

        $option_list = $this->generateOptionList($questionnaire->type, $question->options);

        editMessageText($bot, __('question.test_action_started', [
            'description' => $questionnaire->description,
            'name'        => $questionnaire->name,
            'sort'        => 1,
            'count'       => $this->count,
            'question'    => $question->question,
            'option_list' => $option_list,
        ]), 'html', QuestionKeyboard::question($questionnaire, $question, $this->has_finished_results));

        $this->next('answer');
    }

    public function answer(Nutgram $bot)
    {
        [$action, $question, $option_id] = explode(':', $bot->callbackQuery()->data);

        $now                       = microtime(true);
        $last_question_answered_at = $this->last_question_answered_at;

        $this->last_question_answered_at = $now;

        $this->user_questionnaire->update([
            'answers'          => array_merge($this->user_questionnaire->answers, [[
                'option_id' => $option_id,
                'interval'  => $now - $last_question_answered_at,
            ]]),
            'session_interval' => $this->user_questionnaire->session_interval + ($now - $last_question_answered_at),
            'status'           => 'processing',
        ]);

        $question      = $this->question;
        $next_question = Question::where('questionnaire_id', $question->questionnaire_id)->where('id', '>', $question->id)->with('options')->first();

        if (! $next_question) {
            return $this->end_action($bot);
        }

        $this->next_question($bot, $next_question);
    }

    public function next_question(Nutgram $bot, $question)
    {
        $this->question = $question;

        $option_list = $this->generateOptionList($this->questionnaire->type, $this->question->options);

        editMessageText($bot, __('question.test_action', [
            'name'        => $this->questionnaire->name,
            'sort'        => $question->sort,
            'count'       => $this->count,
            'question'    => $question->question,
            'option_list' => trim($option_list),
        ]), 'html', QuestionKeyboard::question($this->questionnaire, $question, false));

        $this->next('answer');
    }

    public function end_action(Nutgram $bot)
    {
        $collection  = collect($this->user_questionnaire->answers);
        $option_list = $collection->pluck('option_id');

        $overall_score = QuestionOption::whereIn('id', $option_list)->get()->sum('score');

        $result = QuestionnaireResult::where('from', '<=', $overall_score)
            ->where('to', '>=', $overall_score)
            ->where('questionnaire_id', $this->question->questionnaire_id)
            ->first();

        $this->user_questionnaire->update([
            'overall_score' => $overall_score,
            'status'        => 'completed',
        ]);

        editMessageText($bot, __('question.finish_action', [
            'category'    => $this->questionnaire->category->name,
            'name'        => $this->questionnaire->name,

            'score'       => $overall_score,
            'description' => $result->description,
        ]), 'html', QuestionKeyboard::endAction($this->questionnaire));

        return $this->end();
    }
}
