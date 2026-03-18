<?php

namespace Bot\Handler;

use Bot\Key\Keyboard;
use SergiX44\Nutgram\Nutgram;

class MainHandler extends Handler
{
    public function start(Nutgram $bot, $username = null)
    {
        $user = $bot->chat()->username ? '@'.$bot->chat()->username : $bot->chat()->first_name;

        sendMessage($bot, __('message.start', ['user' => $user]), 'html', Keyboard::main());
    }

    public function home(Nutgram $bot)
    {
        $user = $bot->chat()->username ? '@'.$bot->chat()->username : $bot->chat()->first_name;

        editMessageText($bot, __('message.start', ['user' => $user]), 'html', Keyboard::main());
    }

    public function contacts(Nutgram $bot)
    {
        editMessageText($bot, __('message.contacts'), 'html', Keyboard::home());
    }
}
