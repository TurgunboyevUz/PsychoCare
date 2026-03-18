<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use SergiX44\Nutgram\Nutgram;

class BotRun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Nutgram Telegram Bot';

    /**
     * Execute the console command.
     */
    public function handle(Nutgram $bot)
    {
        try {
            $bot->run();
        } catch (\Exception $e) {
            sleep(3);

            Log::error($e->getMessage());

            $this->handle($bot);
        }
    }
}
