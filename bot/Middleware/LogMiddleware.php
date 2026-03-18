<?php
namespace Bot\Middleware;

use App\Models\TeleUser;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ChatType;

class LogMiddleware
{
    public function __invoke(Nutgram $bot, $next)
    {
        if ($bot->chat()->type != ChatType::PRIVATE) {$next($bot);return;}

        $user = TeleUser::where('user_id', $bot->chatId())->first();

        activity()->causedBy($user)->log($bot->callbackQuery()?->data ?? $bot->message()->text);

        $next($bot);
    }
}
