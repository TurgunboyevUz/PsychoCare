<?php

namespace Filament\Admin\Resources\TeleUsers\Widgets;

use App\Models\TeleUser;
use Filament\Widgets\ChartWidget;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;

class HourlyActivityChart extends ChartWidget
{
    public ?TeleUser $record = null;

    // Sarlavha va tavsif o'zbek tilida
    protected ?string $heading = '🕐 Kun davomidagi faollik';
    protected ?string $description = 'Foydalanuvchining bot bilan ishlash vaqtlari';
    protected int|string|array $columnSpan = 'full';
    protected ?string $maxHeight = '250px';

    protected function getFilters(): ?array
    {
        // Filtrlarni o'zbekcha tarjimasi
        return [
            'today' => 'Bugun',
            'yesterday' => 'Kecha',
            '7days' => 'Oxirgi 7 kun',
            '30days' => 'Oxirgi 30 kun',
        ];
    }

    protected function getData(): array
    {
        $uid = $this->record->id;
        $tz  = (int) $this->record->timezone;

        [$start, $end] = $this->resolveRange();

        $hours = Activity::query()
            ->where('causer_id', $uid)
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw("HOUR(created_at + INTERVAL {$tz} HOUR) as hour, COUNT(*) as cnt")
            ->groupBy('hour')
            ->pluck('cnt', 'hour')
            ->toArray();

        $labels = [];
        $data   = [];

        for ($h = 0; $h < 24; $h++) {
            $labels[] = sprintf('%02d:00', $h);
            $data[]   = $hours[$h] ?? 0;
        }

        return [
            'datasets' => [
                [
                    // Grafikdagi ko'rsatkich nomi o'zbekcha
                    'label' => 'Faollik',
                    'data' => $data,
                    'backgroundColor' => 'rgba(59,130,246,0.7)',
                    'borderRadius' => 4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function resolveRange(): array
    {
        return match ($this->filter) {
            'today' => [now()->startOfDay(), now()],
            'yesterday' => [
                now()->subDay()->startOfDay(),
                now()->subDay()->endOfDay(),
            ],
            '30days' => [now()->subDays(30), now()],
            default => [now()->subDays(7), now()],
        };
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => false],
                'tooltip' => ['mode' => 'index'],
            ],
            'scales' => [
                'x' => [
                    'grid' => ['display' => false],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'grid' => ['color' => 'rgba(0,0,0,0.04)'],
                ],
            ],
            'responsive' => true,
            'maintainAspectRatio' => false,
        ];
    }
}