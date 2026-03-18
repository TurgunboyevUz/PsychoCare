<?php
namespace Bot\Chat;

use App\Models\Mood;
use App\Models\TeleUser;
use Bot\Key\MoodKeyboard;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class EditMoodChat extends Conversation
{
    public $id;

    protected function getSerializableAttributes(): array
    {
        return [
            'id' => $this->id,
        ];
    }

    public function start(Nutgram $bot, $id)
    {
        $this->id  = $id;
        $mood      = Mood::find($id);
        $user      = TeleUser::where('user_id', $bot->chatId())->first();
        $user_mood = $user->mood_types()->where('mood_id', $id)->first();

        editMessageText($bot, __('mood.change_mood_item', [
            'label'       => $mood->{$user->mood_style . '_label'},
            'description' => $user_mood?->description ?? $mood->description,
        ]), 'html', MoodKeyboard::backTemplates());

        $this->next('mood_input');
    }

    public function mood_input(Nutgram $bot)
    {
        $user = TeleUser::where('user_id', $bot->chatId())->first();
        $user->mood_types()->updateOrCreate(['mood_id' => $this->id], [
            'description' => $bot->message()->text,
        ]);

        sendMessage($bot, __('mood.mood_item_changed'), 'html', MoodKeyboard::backTemplates(), reply_to_message_id: $bot->messageId());

        $this->end();
    }
}
