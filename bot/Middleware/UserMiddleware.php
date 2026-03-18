<?php

namespace Bot\Middleware;

use App\Models\TeleUser;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ChatType;

class UserMiddleware
{
    public function __invoke(Nutgram $bot, $next)
    {
        if ($bot->chat()->type == ChatType::PRIVATE) {
            TeleUser::updateOrCreate(['user_id' => $bot->chatId()], [
                'first_name' => $bot->chat()->first_name,
                'last_name' => $bot->chat()->last_name,
                'username' => $bot->chat()->username,
                'is_active' => true
            ]);
        }

        $next($bot);
    }
}
