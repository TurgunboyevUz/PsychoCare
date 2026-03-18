<?php
namespace Filament\Admin\Resources\TeleUsers\Pages;

use Filament\Admin\Resources\TeleUsers\TeleUserResource;
use Filament\Admin\Resources\TeleUsers\Widgets\DailyActivityChart;
use Filament\Admin\Resources\TeleUsers\Widgets\HourlyActivityChart;
use Filament\Admin\Resources\TeleUsers\Widgets\SessionsTable;
use Filament\Admin\Resources\TeleUsers\Widgets\UserActivityOverview;
use Filament\Resources\Pages\ViewRecord;

class ViewTeleUser extends ViewRecord
{
    protected static string $resource = TeleUserResource::class;

    // Barcha widgetlarni shu yerda ro'yxatdan o'tkazish SHART
    public function getWidgets(): array
    {
        return [
            UserActivityOverview::class,
            HourlyActivityChart::class,
            DailyActivityChart::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            UserActivityOverview::make([
                'record' => $this->record,
            ]),
            HourlyActivityChart::make([
                'record' => $this->record,
            ]),
            DailyActivityChart::make([
                'record' => $this->record,
            ]),
        ];
    }

    public function getFooterWidgetsColumns(): int | array
    {
        return 3;
    }
}
