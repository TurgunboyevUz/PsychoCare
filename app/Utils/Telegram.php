<?php

use Illuminate\Support\Facades\Log;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ChatMemberStatus;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton as InlineButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup as InlineKeyboard;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton as ResizeButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup as ResizeKeyboard;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardRemove as RemoveKeyboard;
use SergiX44\Nutgram\Telegram\Types\Message\ReplyParameters;

function sendMessage(Nutgram $bot, $text, $parse_mode = 'html', $reply_markup = null, $disable_web_page_preview = true, $chat_id = null, $reply_to_message_id = null)
{
    $parse_mode = ($parse_mode == 'html') ? ParseMode::HTML : ParseMode::MARKDOWN;
    $reply_parameters = $reply_to_message_id ? ReplyParameters::make($reply_to_message_id, allow_sending_without_reply: false) : null;
    
    if (mb_strlen($text) <= 4096) {
        return $bot->sendMessage(...compact('chat_id', 'text', 'parse_mode', 'reply_markup', 'disable_web_page_preview', 'reply_parameters'));
    }
    
    $messages = [];
    $chunks = splitLongText($text);
    
    foreach ($chunks as $index => $chunk) {
        try {
            if ($index === count($chunks) - 1) {
                $message = $bot->sendMessage(
                    chat_id: $chat_id,
                    text: $chunk,
                    parse_mode: $parse_mode,
                    reply_markup: $reply_markup,
                    disable_web_page_preview: $disable_web_page_preview,
                    reply_parameters: ReplyParameters::make($reply_to_message_id)
                );
            } else {
                $message = $bot->sendMessage(
                    chat_id: $chat_id,
                    text: $chunk,
                    parse_mode: $parse_mode,
                    disable_web_page_preview: $disable_web_page_preview,
                    reply_parameters: $reply_parameters
                );
            }
            
            $messages[] = $message;
            
            if ($index < count($chunks) - 1) {
                usleep(500000);
            }
            
        } catch (\Exception $e) {
            Log::error("Error sending message part {$index}: " . $e->getMessage());
            continue;
        }
    }
    
    return $messages;
}

function sendPhoto(Nutgram $bot, $photo, $caption = null, $parse_mode = 'html', $reply_markup = null, $chat_id = null)
{
    try {
        $parse_mode = ($parse_mode == 'html') ? ParseMode::HTML : ParseMode::MARKDOWN;

        return $bot->sendPhoto(...compact('chat_id', 'photo', 'caption', 'parse_mode', 'reply_markup'));
    } catch (\Exception $e) {
        return;
    }
}

function sendVideo(Nutgram $bot, $video, $caption = null, $parse_mode = 'html', $reply_markup = null, $chat_id = null)
{
    try {
        $parse_mode = ($parse_mode == 'html') ? ParseMode::HTML : ParseMode::MARKDOWN;

        return $bot->sendVideo(...compact('chat_id', 'video', 'caption', 'parse_mode', 'reply_markup'));
    } catch (\Exception $e) {
        return;
    }
}

function sendAnimation(Nutgram $bot, $animation, $caption = null, $parse_mode = 'html', $reply_markup = null, $chat_id = null)
{
    try {
        $parse_mode = ($parse_mode == 'html') ? ParseMode::HTML : ParseMode::MARKDOWN;

        return $bot->sendAnimation(...compact('chat_id', 'animation', 'caption', 'parse_mode', 'reply_markup'));
    } catch (\Exception $e) {
        return;
    }
}

function sendDocument(Nutgram $bot, $document, $caption = null, $parse_mode = 'html', $reply_markup = null, $chat_id = null)
{
    try {
        $parse_mode = ($parse_mode == 'html') ? ParseMode::HTML : ParseMode::MARKDOWN;

        return $bot->sendDocument(...compact('chat_id', 'document', 'caption', 'parse_mode', 'reply_markup'));
    } catch (\Exception $e) {
        return;
    }
}

function editMessageText(Nutgram $bot, $text, $parse_mode = 'html', $reply_markup = null, $disable_web_page_preview = true, $chat_id = null, $message_id = null)
{
    try {
        $parse_mode = ($parse_mode == 'html') ? ParseMode::HTML : ParseMode::MARKDOWN;

        return $bot->editMessageText(...compact('chat_id', 'message_id', 'text', 'parse_mode', 'reply_markup', 'disable_web_page_preview'));
    } catch (\Exception $e) {
        return;
    }
}

function editMessageCaption(Nutgram $bot, $caption, $parse_mode = 'html', $reply_markup = null, $chat_id = null, $message_id = null)
{
    try {
        $parse_mode = ($parse_mode == 'html') ? ParseMode::HTML : ParseMode::MARKDOWN;

        return $bot->editMessageCaption(...compact('chat_id', 'message_id', 'caption', 'parse_mode', 'reply_markup'));
    } catch (\Exception $e) {
        return;
    }
}

function deleteMessage(Nutgram $bot, $chat_id = null, $message_id = null)
{
    try {
        if (empty($chat_id) || empty($message_id)) {
            return $bot->message()->delete();
        } else {
            return $bot->deleteMessage(...compact('chat_id', 'message_id'));
        }
    } catch (\Exception $e) {
        return;
    }
}

function copyMessage(Nutgram $bot, $chat_id = null, $from_chat_id = null, $message_id = null, $caption = null, $parse_mode = 'html', $reply_markup = null)
{
    try {
        $parse_mode = ($parse_mode == 'html') ? ParseMode::HTML : ParseMode::MARKDOWN;

        return $bot->copyMessage(...compact('chat_id', 'from_chat_id', 'message_id', 'caption', 'parse_mode', 'reply_markup'));
    } catch (\Exception $e) {
        return;
    }
}

function forwardMessage(Nutgram $bot, $chat_id = null, $from_chat_id = null, $message_id = null)
{
    try {
        return $bot->forwardMessage(...compact('chat_id', 'from_chat_id', 'message_id'));
    } catch (\Exception $e) {
        return;
    }
}

function editMessageReplyMarkup(Nutgram $bot, $reply_markup = null, $chat_id = null, $message_id = null)
{
    try {
        return $bot->editMessageReplyMarkup(...compact('chat_id', 'message_id', 'reply_markup'));
    } catch (\Exception $e) {
        return;
    }
}

function answerCallbackQuery(Nutgram $bot, $text, $show_alert)
{
    return $bot->answerCallbackQuery(...compact('text', 'show_alert'));
}

function getChat(Nutgram $bot, $chat_id)
{
    return $bot->getChat($chat_id);
}

function isChatMember(Nutgram $bot, $chat_id, $user_id = null)
{
    try {
        $user_id = $user_id ?? $bot->chatId();
        $status = $bot->getChatMember($chat_id, $user_id)->status;

        return $status == ChatMemberStatus::MEMBER || $status == ChatMemberStatus::CREATOR || $status == ChatMemberStatus::ADMINISTRATOR;
    } catch (\Exception $e) {
        return;
    }
}

function isChatAdmin(Nutgram $bot, $chat_id, $user_id = null)
{
    try {
        $user_id = $user_id ?? $bot->chatId();
        $status = $bot->getChatMember($chat_id, $user_id)->status;

        return $status == ChatMemberStatus::ADMINISTRATOR || $status == ChatMemberStatus::CREATOR;
    } catch (\Exception $e) {
        return;
    }
}

function inlineKeyboard($buttons): InlineKeyboard
{
    $keyboard = InlineKeyboard::make();

    $makeButton = function ($button) {
        return InlineButton::make(...$button);
    };

    $makeRow = function ($buttons) use ($makeButton) {
        $row = [];

        if (array_keys($buttons) === range(0, count($buttons) - 1)) {
            foreach ($buttons as $button) {
                $row[] = $makeButton($button);
            }

            return $row;
        } else {
            return [$makeButton($buttons)];
        }
    };

    foreach ($buttons as $row) {
        $current_row = $makeRow($row);

        $keyboard->addRow(...$current_row);
    }

    return $keyboard;
}

function resizeKeyboard($buttons, $resize = true, $one_time_keyboard = false, $selective = false)
{
    $keyboard = ResizeKeyboard::make($resize, $one_time_keyboard, selective: $selective);

    $makeButton = function ($button) {
        return ResizeButton::make(...$button);
    };

    $makeRow = function ($buttons) use ($makeButton) {
        $row = [];

        if (array_keys($buttons) === range(0, count($buttons) - 1)) {
            foreach ($buttons as $button) {
                $row[] = $makeButton($button);
            }

            return $row;
        } else {
            return [$makeButton($buttons)];
        }
    };

    foreach ($buttons as $row) {
        $current_row = $makeRow($row);

        $keyboard->addRow(...$current_row);
    }

    return $keyboard;
}

function removeKeyboard()
{
    return RemoveKeyboard::make(true);
}

function splitLongText(string $text, int $maxLength = 4096): array
{
    if (mb_strlen($text) <= $maxLength) {
        return [$text];
    }
    
    $chunks = [];
    $remainingText = $text;
    
    while (mb_strlen($remainingText) > 0) {
        if (mb_strlen($remainingText) <= $maxLength) {
            $chunks[] = $remainingText;
            break;
        }
        
        $chunk = mb_substr($remainingText, 0, $maxLength);
        
        $lastNewline = mb_strrpos($chunk, "\n");
        
        $lastSentence = mb_strrpos($chunk, ".");
        
        $breakPos = $maxLength;
        
        if ($lastSentence !== false && $lastSentence > $maxLength * 0.7) {
            $breakPos = $lastSentence + 1; // +1 чтобы включить точку
        } elseif ($lastNewline !== false && $lastNewline > $maxLength * 0.7) {
            $breakPos = $lastNewline + 1; // +1 чтобы включить перенос строки
        } else {
            $lastSpace = mb_strrpos($chunk, " ");
            if ($lastSpace !== false && $lastSpace > $maxLength * 0.7) {
                $breakPos = $lastSpace + 1; // +1 чтобы включить пробел
            }
        }
        
        $currentChunk = mb_substr($remainingText, 0, $breakPos);
        $remainingText = mb_substr($remainingText, $breakPos);
        
        if (!empty($chunks)) {
            $currentChunk = "..." . ltrim($currentChunk);
        }
        
        if (mb_strlen($remainingText) > 0) {
            $currentChunk = rtrim($currentChunk) . "...";
        }
        
        $chunks[] = $currentChunk;
    }
    
    return $chunks;
}