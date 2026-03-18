<?php
namespace Bot\Middleware;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ChatType;

class PrivateMiddleware
{
    public function __invoke(Nutgram $bot, $next)
    {
        if ($bot->chat()->type == ChatType::PRIVATE) {
            return $next($bot);
        }
    }
}
