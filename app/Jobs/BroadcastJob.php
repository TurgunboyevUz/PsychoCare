<?php declare (strict_types = 1);
namespace App\Jobs;

use App\Models\Broadcast;
use App\Models\BroadcastLog;
use App\Models\TeleUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Nutgram\Laravel\Facades\Telegram;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Message\LinkPreviewOptions;
use Throwable;

class BroadcastJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $broadcast_id,
        public ?int $last_user_id = null
    ) {}

    public function handle(): void
    {
        $broadcast = Broadcast::findOrFail($this->broadcast_id);

        if ($broadcast->status === 'completed') {
            return;
        }

        $users = TeleUser::query()
            ->where('is_active', true)
            ->whereDoesntHave('logs', function ($q) {
                $q->where('broadcast_id', $this->broadcast_id)->where('sent', true);
            })
            ->when($this->last_user_id, fn($q) => $q->where('id', '>', $this->last_user_id))
            ->orderBy('id')
            ->limit(20)
            ->get();

        if ($users->isEmpty()) {
            $broadcast->update(['status' => 'completed']);
            return;
        }

        $bot      = app(Nutgram::class);
        $keyboard = empty($broadcast->buttons) ? null : $this->buildKeyboard($broadcast->buttons);

        foreach ($users as $user) {
            $log = BroadcastLog::firstOrCreate([
                'broadcast_id' => $broadcast->id,
                'tele_user_id' => $user->id,
            ], ['sent' => false]);

            if ($log->sent === true) {
                $this->last_user_id = $user->id;
                continue;
            }

            try {
                $bot->sendMessage(
                    text: $broadcast->content,
                    chat_id: $user->user_id,
                    parse_mode: ParseMode::HTML,
                    reply_markup: $keyboard,
                    disable_notification: ! $broadcast->notification,
                    link_preview_options: !$broadcast->image_url() ? null : LinkPreviewOptions::make(is_disabled:false, url: $broadcast->image_url(), show_above_text: $broadcast->in_top)
                );

                $log->update(['sent' => true]);
                $broadcast->increment('sent');
            } catch (Throwable $e) {
                if ($this->isRateLimitError($e)) {
                    self::dispatch(
                        $this->broadcast_id,
                        $this->last_user_id
                    )->delay(now()->addSeconds($this->getRetryAfter($e)));

                    return;
                }

                $log->update(['sent' => false, 'fail_reason' => $e->getMessage()]);
                $user->update(['is_active' => false]);
                $broadcast->increment('failed');
            }

            $this->last_user_id = $user->id;
        }

        self::dispatch(
            $this->broadcast_id,
            $this->last_user_id
        );
    }

    private function isRateLimitError(Throwable $e): bool
    {
        return str_contains($e->getMessage(), 'Too Many Requests')
        || str_contains($e->getMessage(), '429');
    }

    private function getRetryAfter(Throwable $e): int
    {
        if (preg_match('/retry after (\d+)/i', $e->getMessage(), $m)) {
            return (int) $m[1];
        }

        return 3;
    }

    private function buildKeyboard(array $buttons)
    {
        $keyboard = [];

        foreach ($buttons as $button) {
            $row = [];
            foreach ($button['button'] as $button_text => $button_url) {
                $row[] = ['text' => $button_text, 'url' => $button_url];
            }

            $keyboard[] = $row;
        }

        return inlineKeyboard($keyboard);
    }
}
