<?php declare(strict_types=1);
namespace App\Schedules;

use App\Jobs\BroadcastJob;
use App\Models\Broadcast;

class BroadcastSchedule
{
    public function __invoke()
    {
        if (Broadcast::where('status', 'processing')->exists()) {return;}

        $broadcast = Broadcast::where('status', 'pending')->where('scheduled_at', null)->first();
        if (! $broadcast) {
            $broadcast = Broadcast::where('status', 'pending')->where('scheduled_at', '<=', now('Europe/Moscow'))->first();

            if (! $broadcast) {return;}
        }

        $broadcast->update(['status' => 'processing']);

        BroadcastJob::dispatch($broadcast->id);
    }
}
