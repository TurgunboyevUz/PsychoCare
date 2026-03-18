<?php
namespace Bot\Middleware;

use SergiX44\Nutgram\Nutgram;

class ClarificationMiddleware
{
    public function __invoke(Nutgram $bot, $next)
    {
        if (! $bot->message()->reply_to_message) {return;}

        $message = $bot->message()->reply_to_message;
        $text    = $message->text ?? $message->caption;

        if (! str_starts_with($text, '#ответ')) {return;}

        $next($bot);
    }
}