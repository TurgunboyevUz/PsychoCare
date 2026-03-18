<?php
namespace Bot\Key;

use App\Models\Mood;
use App\Models\TeleUser;
use Carbon\Carbon;

class MoodKeyboard
{
    public static function list($moods, $type = 'emoji')
    {
        $keyboard = [];
        foreach ($moods as $mood) {
            $keyboard[] = ['text' => $mood->{$type . '_label'}, 'callback_data' => 'mood:' . $mood->id];
        }
        $keyboard   = array_chunk($keyboard, 3);
        $keyboard[] = ['text' => __('button.make_graph'), 'callback_data' => 'make_graph'];
        $keyboard[] = ['text' => __('button.mood_settings'), 'callback_data' => 'mood_settings'];

        $keyboard[] = ['text' => __('button.home'), 'callback_data' => 'home'];

        return inlineKeyboard($keyboard);
    }

    public static function changeMood($comment = false)
    {
        $keyboard   = [];
        $keyboard[] = ['text' => __('button.change_mood'), 'callback_data' => 'change_mood'];
        if ($comment) {
            $keyboard[] = ['text' => __('button.rewrite_comment'), 'callback_data' => 'rewrite_comment'];
        }

        $keyboard[] = ['text' => __('button.make_graph'), 'callback_data' => 'make_graph'];
        $keyboard[] = ['text' => __('button.mood_settings'), 'callback_data' => 'mood_settings'];
        $keyboard[] = ['text' => __('button.home'), 'callback_data' => 'home'];

        return inlineKeyboard($keyboard);
    }

    public static function forceChange(TeleUser $user, Mood $mood)
    {
        return inlineKeyboard([
            ['text' => __('button.change_to', ['label' => $mood->{$user->mood_style . '_label'}]), 'callback_data' => 'change_to:' . $mood->id],
            ['text' => __('button.back'), 'callback_data' => 'daily_mood'],
        ]);
    }

    public static function rewriteComment()
    {
        return inlineKeyboard([
            ['text' => __('button.make_graph'), 'callback_data' => 'make_graph'],
            ['text' => __('button.mood_settings'), 'callback_data' => 'mood_settings'],
            ['text' => __('button.home'), 'callback_data' => 'home'],
        ]);
    }

    public static function settings()
    {
        return inlineKeyboard([
            ['text' => __('button.notifications'), 'callback_data' => 'notifications'],
            ['text' => __('button.template_mood'), 'callback_data' => 'templates'],
            ['text' => __('button.back'), 'callback_data' => 'daily_mood'],
        ]);
    }

    public static function notifications(TeleUser $user)
    {
        $keyboard = [];

        $hours = range(0, 23);

        $labels = array_map(fn($value) => str_pad($value, 2, '0', STR_PAD_LEFT), $hours);

        $emojis = [
            '🕛', '🕐', '🕑', '🕒',
            '🕓', '🕔', '🕕', '🕖',
            '🕗', '🕘', '🕙', '🕚',
            '🕛', '🕐', '🕑', '🕒',
            '🕓', '🕔', '🕕', '🕖',
            '🕗', '🕘', '🕙', '🕚',
        ];

        $user_hours = $user->notifications()->pluck('time')->toArray();

        foreach ($hours as $hour) {
            $label = in_array($hour, $user_hours) ? $labels[$hour] . ':00' . $emojis[$hour] : $labels[$hour] . ':00';

            $keyboard[] = [
                'text'          => $label,
                'callback_data' => "notification:{$hour}",
            ];
        }

        $keyboard   = array_chunk($keyboard, 3);
        $keyboard[] = ['text' => __('button.back'), 'callback_data' => 'daily_mood'];

        return inlineKeyboard($keyboard);
    }

    public static function changeList($moods, $type = 'emoji')
    {
        $keyboard = [];
        foreach ($moods as $mood) {
            $keyboard[] = ['text' => $mood->{$type . '_label'}, 'callback_data' => 'edit:' . $mood->id];
        }
        $keyboard   = array_chunk($keyboard, 3);
        $keyboard[] = ['text' => __('button.toggle_' . $type), 'callback_data' => 'toggle_template'];
        $keyboard[] = ['text' => __('button.set_as_default'), 'callback_data' => 'set_default'];
        $keyboard[] = ['text' => __('button.home'), 'callback_data' => 'home'];

        return inlineKeyboard($keyboard);
    }

    public static function backSettings()
    {
        return inlineKeyboard([
            ['text' => __('button.back'), 'callback_data' => 'mood_settings'],
        ]);
    }

    public static function backTemplates()
    {
        return inlineKeyboard([
            ['text' => __('button.back'), 'callback_data' => 'templates'],
        ]);
    }

    public static function backMood()
    {
        return inlineKeyboard([
            ['text' => __('button.back'), 'callback_data' => 'daily_mood'],
        ]);
    }

    public static function userNotification()
    {
        return inlineKeyboard([
            [
                ['text' => __('button.mark_mood'), 'callback_data' => 'daily_mood'],
                ['text' => __('button.mood_setup'), 'callback_data' => 'mood_settings'],
            ],
        ]);
    }
}
