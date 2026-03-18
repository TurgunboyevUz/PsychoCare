<?php

namespace Filament\Admin\Resources\TeleUsers\Widgets;

use App\Models\TeleUser;
use Filament\Widgets\ChartWidget;
use Spatie\Activitylog\Models\Activity;

class DailyActivityChart extends ChartWidget
{
    public ?TeleUser $record = null;

    // Sarlavha tarjimasi
    protected ?string $heading             = '📈 Foydalanuvchi faolligi';
    protected int|string|array $columnSpan = 'full';
    protected ?string $maxHeight           = '250px';

    public ?string $start_date = null;
    public ?string $end_date   = null;

    protected function getFilters(): ?array
    {
        // Filtrlarni o'zbek tiliga o'tkazamiz
        return [
            '15' => 'Oxirgi 15 kun',
            '30' => 'Oxirgi 30 kun',
            '90' => 'Oxirgi 90 kun',
        ];
    }

    protected function getData(): array
    {
        $uid = $this->record->id;

        $days = $this->filter ?? 15;

        $start = now()->subDays($days);
        $end   = now();

        $range = collect(range($days, 0))
            ->map(fn($i) => now()->subDays($i)->toDateString());

        $activityCounts = Activity::query()
            ->where('causer_type', get_class($this->record))
            ->where('causer_id', $uid)
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE(created_at) as day, COUNT(*) as cnt')
            ->groupBy('day')
            ->pluck('cnt', 'day');

        $labels = $range->map(fn($d) => \Carbon\Carbon::parse($d)->format('d.m'))->toArray();

        $data = $range->map(fn($d) => $activityCounts[$d] ?? 0)->toArray();

        return [
            'datasets' => [
                [
                    // Grafik chizig'i nomi o'zbekcha
                    'label'           => 'Faollik',
                    'data'            => $data,
                    'borderColor'     => 'rgb(59,130,246)',
                    'backgroundColor' => 'rgba(59,130,246,0.1)',
                    'tension'         => 0.4,
                    'fill'            => true,
                ],
            ],
            'labels'   => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}