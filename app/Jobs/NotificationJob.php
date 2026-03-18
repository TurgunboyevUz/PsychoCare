<?php
namespace App\Jobs;

use App\Models\NotificationLog;
use App\Models\TeleUser;
use Bot\Key\MoodKeyboard as KeyMoodKeyboard;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use SergiX44\Nutgram\Nutgram;
use Throwable;

class NotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle($users): void
    {
        $bot = app(Nutgram::class);

        foreach ($users as $user) {
            try {
                sendMessage($bot, __('notification_message'), 'html', KeyMoodKeyboard::userNotification(), chat_id: $user);

                NotificationLog::create([
                    'tele_user_id' => TeleUser::where('user_id', $user)->first()->id,
                ]);
            } catch (Throwable $e) {
                //
            }
        }
    }
}
