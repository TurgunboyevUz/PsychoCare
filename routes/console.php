<?php

use App\Schedules\BroadcastSchedule;
use App\Schedules\NotificationSchedule;
use Illuminate\Support\Facades\Schedule;

Schedule::call(new NotificationSchedule)->hourly();
Schedule::call(new BroadcastSchedule)->everyMinute();
