<?php

namespace Filament\Admin\Resources\TeleUsers\Widgets;

use App\Models\TeleUser;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserActivityOverview extends BaseWidget
{
    public ?TeleUser $record = null;

    protected function getStats(): array
    {
        $uid = $this->record->id;

        // Testning o'rtacha davomiyligi
        $avgDuration = DB::table('user_questionnaires')
            ->where('tele_user_id', $uid)
            ->where('status', 'completed')
            ->avg('session_interval');

        $durationLabel = $avgDuration
            ? gmdate('i:s', (int) $avgDuration) . ' daqiqa'
            : '—';

        // Bekor qilish foizi
        $totalStarted   = DB::table('user_questionnaires')->where('tele_user_id', $uid)->count();
        $totalCancelled = DB::table('user_questionnaires')->where('tele_user_id', $uid)->where('status', 'cancelled')->count();
        $totalCompleted = DB::table('user_questionnaires')->where('tele_user_id', $uid)->where('status', 'completed')->count();
        $cancelRate     = $totalStarted > 0 ? round($totalCancelled / $totalStarted * 100) : 0;

        // Eslatmalarni e'tiborsiz qoldirish
        $totalNotif     = DB::table('notification_logs')->where('tele_user_id', $uid)->count();
        $respondedNotif = DB::table('notification_logs')->where('tele_user_id', $uid)->whereNotNull('responded_at')->count();
        $ignoreRate     = $totalNotif > 0 ? round(($totalNotif - $respondedNotif) / $totalNotif * 100) : 0;

        // Faollik chastotasi
        $moodDays = DB::table('user_moods')->where('tele_user_id', $uid)->selectRaw('DATE(created_at) as day')->groupBy('day')->pluck('day');
        $questDays = DB::table('user_questionnaires')->where('tele_user_id', $uid)->selectRaw('DATE(created_at) as day')->groupBy('day')->pluck('day');
        $allDays      = $moodDays->merge($questDays)->unique()->sort()->values();
        $activeDays   = $allDays->count();
        $firstDay     = $allDays->first();
        $lastDay      = $allDays->last();
        $span         = ($firstDay && $lastDay) ? Carbon::parse($firstDay)->diffInDays(Carbon::parse($lastDay)) + 1 : 1;
        $freqDays     = $activeDays > 0 ? round($span / $activeDays, 1) : null;

        // Mustaqil to'ldirish ulushi
        $selfMoods    = DB::table('user_moods')->where('tele_user_id', $uid)->where('via_notification', false)->count();
        $totalMoods   = DB::table('user_moods')->where('tele_user_id', $uid)->count();
        $selfRate     = $totalMoods > 0 ? round($selfMoods / $totalMoods * 100) : 0;

        // Oxirgi 7 kunlik trendlar
        $last7 = collect(range(6, 0))->map(function ($daysAgo) use ($uid) {
            $date = now()->subDays($daysAgo)->toDateString();
            $moods = DB::table('user_moods')->where('tele_user_id', $uid)->whereDate('created_at', $date)->count();
            $tests = DB::table('user_questionnaires')->where('tele_user_id', $uid)->whereDate('created_at', $date)->count();
            return $moods + $tests;
        })->toArray();

        return [
            Stat::make('⏱ O‘rtacha test vaqti', $durationLabel)
                ->description("Yakunlangan testlar: {$totalCompleted}")
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('primary')
                ->chart($last7),

            Stat::make('🚪 Bekor qilish foizi', $cancelRate . '%')
                ->description("{$totalStarted} tadan {$totalCancelled} ta test")
                ->descriptionIcon($cancelRate > 50 ? 'heroicon-m-x-circle' : 'heroicon-m-check-circle')
                ->color($cancelRate > 50 ? 'danger' : ($cancelRate > 25 ? 'warning' : 'success'))
                ->chart($last7),

            Stat::make('🔔 Eslatmalarga javob bermaslik', $ignoreRate . '%')
                ->description("{$totalNotif} tadan {$respondedNotif} ta javob")
                ->descriptionIcon($ignoreRate > 60 ? 'heroicon-m-bell-slash' : 'heroicon-m-bell')
                ->color($ignoreRate > 60 ? 'danger' : ($ignoreRate > 30 ? 'warning' : 'success'))
                ->chart($last7),

            Stat::make('📅 Faollik chastotasi', $freqDays ? "har {$freqDays} kunda" : '—')
                ->description("Faol kunlar: {$activeDays}")
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color($freqDays === null ? 'gray' : ($freqDays <= 1 ? 'success' : ($freqDays <= 3 ? 'info' : ($freqDays <= 7 ? 'warning' : 'danger'))))
                ->chart($last7),

            Stat::make('✍️ Mustaqil to‘ldirish', $selfRate . '%')
                ->description("{$totalMoods} tadan {$selfMoods} ta holat")
                ->descriptionIcon('heroicon-m-pencil')
                ->color($selfRate > 60 ? 'success' : ($selfRate > 30 ? 'warning' : 'danger'))
                ->chart($last7),
        ];
    }
}