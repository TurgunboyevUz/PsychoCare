<?php
namespace Bot\Handler;

use App\Models\Mood;
use App\Models\NotificationLog;
use App\Models\TeleUser;
use App\Models\UserMood;
use Bot\Key\MoodKeyboard;
use SergiX44\Nutgram\Nutgram;

class MoodHandler extends Handler
{
    public function daily_mood(Nutgram $bot)
    {
        $user     = TeleUser::where('user_id', $bot->chatId())->first();
        $lastMood = UserMood::lastMood($user->id);

        $method = $bot->isCallbackQuery() ? 'editMessageText' : 'sendMessage';

        if (! $lastMood) {
            $moods        = Mood::all();
            $descriptions = $this->prepare_mood_list($user, $moods);

            return $method($bot, __('mood.daily_mood', ['description_list' => trim($descriptions)]), 'html', MoodKeyboard::list($moods, $user->mood_style));
        }

        $mood = $lastMood->mood;

        // ------- KOMMENT YO'Q BO'LSA -------
        if (empty($lastMood->comment)) {
            $method($bot, __('mood.current_mood', [
                'value'       => $mood->value,
                'description' => $mood->description,
            ]), 'html', MoodKeyboard::changeMood(false));

            return $bot->stepConversation(function (Nutgram $bot) use ($lastMood) {
                $lastMood->update(['comment' => $bot->message()->text]);

                sendMessage($bot, __('mood.comment_input'), 'html', reply_to_message_id: $bot->messageId());

                $bot->endConversation();
            });
        }

        // ------ KOMMENT BOR BO'LSA ---------
        return $method($bot, __('mood.current_mood_comment', [
            'value'       => $mood->value,
            'description' => $mood->description,
            'comment'     => $lastMood->comment,
        ]), 'html', MoodKeyboard::changeMood(true));
    }

    public function make_graph(Nutgram $bot)
    {
        $user = TeleUser::where('user_id', $bot->chatId())->first();
        $hash = base64_encode($user->id . '-' . now()->format('d/m/Y H:i'));

        sendMessage($bot, __('mood.daily_mood_graph', [
            'link' => route('mood.index', ['hash' => $hash]),
        ]), 'html');
    }

    public function change_mood(Nutgram $bot)
    {
        $user         = TeleUser::where('user_id', $bot->chatId())->first();
        $moods        = Mood::all();
        $descriptions = $this->prepare_mood_list($user, $moods);

        editMessageText($bot, __('mood.daily_mood', ['description_list' => trim($descriptions)]), 'html', MoodKeyboard::list($moods, $user->mood_style));
    }

    public function choose_mood(Nutgram $bot, $id)
    {
        $user     = TeleUser::firstOrCreate(['user_id' => $bot->userId()]);
        $lastMood = UserMood::lastMood($user->id);

        if ($lastMood) {
            $mood = Mood::find($id);

            if (empty($lastMood->comment)) {
                return editMessageText($bot, __('mood.change_one_hour', [
                    'current_value' => $lastMood->mood->value,
                ]), 'html', MoodKeyboard::forceChange($user, $mood));
            } else {
                return editMessageText($bot, __('mood.change_one_hour_comment', [
                    'current_value' => $lastMood->mood->value,
                    'comment'       => $lastMood->comment,
                ]), 'html', MoodKeyboard::forceChange($user, $mood));
            }
        }

        $notification     = NotificationLog::where('created_at', '>', now()->startOfHour())->where('created_at', '<', now()->endOfHour())->first();
        $via_notification = false;

        if ($notification) {
            $via_notification = true;
            $notification->update(['responded_at' => now()]);
        }

        $mood = $user->moods()->create([
            'mood_id'          => $id,
            'via_notification' => $via_notification,
        ]);

        editMessageText($bot, __('mood.mood_chosen'), 'html', MoodKeyboard::backMood());

        $bot->stepConversation(function (Nutgram $bot) use ($mood) {
            $mood->update(['comment' => $bot->message()->text]);

            sendMessage($bot, __('mood.comment_input'), 'html', reply_to_message_id: $bot->messageId());

            $bot->endConversation();
        });
    }

    public function change_to(Nutgram $bot, $id)
    {
        $user = TeleUser::where('user_id', $bot->chatId())->first();
        $mood = UserMood::lastMood($user->id);

        $mood->update(['mood_id' => $id]);

        if (empty($mood->comment)) {
            editMessageText($bot, __('mood.mood_chosen'), 'html', MoodKeyboard::backMood());

            $bot->stepConversation(function (Nutgram $bot) use ($mood) {
                $mood->update(['comment' => $bot->message()->text]);

                sendMessage($bot, __('mood.comment_input'), 'html', reply_to_message_id: $bot->messageId());

                $bot->endConversation();
            });
        } else {
            editMessageText($bot, __('mood.mood_chosen_with_comment', [
                'comment' => $mood->comment,
            ]), 'html', MoodKeyboard::backMood());
        }
    }

    public function rewrite_comment(Nutgram $bot)
    {
        $user = TeleUser::where('user_id', $bot->chatId())->first();
        $mood = UserMood::lastMood($user->id);

        editMessageText($bot, __('mood.rewrite_comment'), 'html', MoodKeyboard::rewriteComment());

        $bot->stepConversation(function (Nutgram $bot) use ($mood) {
            $mood->update(['comment' => $bot->message()->text]);

            sendMessage($bot, __('mood.comment_input'), 'html', reply_to_message_id: $bot->messageId());

            $bot->endConversation();
        });
    }

    public function settings(Nutgram $bot)
    {
        editMessageText($bot, __('mood.mood_settings'), 'html', MoodKeyboard::settings());
    }

    public function notifications(Nutgram $bot)
    {
        $user      = TeleUser::where('user_id', $bot->chatId())->first();
        $timezones = [
            'UTC-8'  => 'Америка/Лос-Анджелес',
            'UTC-7'  => 'Америка/Денвер',
            'UTC-6'  => 'Америка/Чикаго',
            'UTC-5'  => 'Америка/Нью-Йорк',
            'UTC-4'  => 'Америка/Сантьяго',
            'UTC-3'  => 'Америка/Сан-Паулу',
            'UTC-2'  => 'Атлантика/Южная Георгия',
            'UTC-1'  => 'Атлантика/Азорские о-ва',
            'UTC'    => 'Европа/Лондон',
            'UTC+1'  => 'Европа/Берлин',
            'UTC+2'  => 'Европа/Киев',
            'UTC+3'  => 'Европа/Москва',
            'UTC+4'  => 'Азия/Дубай',
            'UTC+5'  => 'Азия/Ташкент',
            'UTC+6'  => 'Азия/Алма-Ата',
            'UTC+7'  => 'Азия/Бангкок',
            'UTC+8'  => 'Азия/Сингапур',
            'UTC+9'  => 'Азия/Токио',
            'UTC+10' => 'Австралия/Сидней',
            'UTC+11' => 'Тихий океан/Нумеа',
        ];

        $timezone = $timezones[$user->timezone_formatted()];

        editMessageText($bot, __('mood.notification_settings', [
            'timezone' => $user->timezone_formatted(),
            'time'     => now()->addHours($user->timezone)->format('H:i'),
            'zone'     => $timezone,
        ]), 'html', MoodKeyboard::notifications($user));
    }

    public function notification(Nutgram $bot, $time)
    {
        $user = TeleUser::where('user_id', $bot->chatId())->first();

        if ($user->notifications()->where('time', $time)->exists()) {
            $user->notifications()->where('time', $time)->delete();
        } else {
            $user->notifications()->create(['time' => $time]);
        }

        editMessageReplyMarkup($bot, MoodKeyboard::notifications($user));
    }

    public function templates(Nutgram $bot)
    {
        $moods = Mood::all();
        $user  = TeleUser::where('user_id', $bot->chatId())->first();

        editMessageText($bot, __('mood.template_settings', [
            'description_list' => trim($this->prepare_mood_list($user, $moods)),
        ]), 'html', MoodKeyboard::changeList($moods, $user->mood_style));
    }

    public function toggle_template(Nutgram $bot)
    {
        $moods            = Mood::all();
        $user             = TeleUser::where('user_id', $bot->chatId())->first();
        $user->mood_style = $user->mood_style == 'emoji' ? 'number' : 'emoji';
        $user->save();

        editMessageText($bot, __('mood.template_settings', [
            'description_list' => trim($this->prepare_mood_list($user, $moods)),
        ]), 'html', MoodKeyboard::changeList($moods, $user->mood_style));
    }

    public function set_default(Nutgram $bot)
    {
        $user = TeleUser::where('user_id', $bot->chatId())->first();

        $user->mood_types()->delete();

        editMessageText($bot, __('mood.default_template_changed'), 'html', MoodKeyboard::backSettings());
    }

    public function prepare_mood_list(TeleUser $user, $moods)
    {
        $descriptions    = '';
        $user_mood_types = $user->mood_types()->get()->keyBy('mood_id');

        foreach ($moods as $mood) {
            $userMoodType = $user_mood_types->get($mood->id);
            $description  = $userMoodType?->description ?? $mood->description;

            $descriptions .= "\n\n" . __('mood.daily_mood_item', [
                'label'       => $mood->{$user->mood_style . '_label'},
                'description' => $description,
            ]);
        }

        return $descriptions;
    }
}
