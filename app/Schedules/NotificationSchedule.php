<?php
namespace App\Schedules;

use App\Jobs\NotificationJob;
use App\Models\TeleUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class NotificationSchedule
{
    public function __invoke()
    {
        $hour = now();

        TeleUser::whereHas('notifications', function (Builder $query) use ($hour) {
            return $query->where('time', $hour);
        })->chunkById(60, function (Collection $users) {
            NotificationJob::dispatch($users->pluck('user_id')->toArray());
        });
    }
}
