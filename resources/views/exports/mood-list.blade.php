<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Дневник настроения - Список</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            src: url('{{ asset('sans-fonts/DejaVuSans.ttf') }}') format('truetype');
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #2d3748;
        }
        .header .subtitle {
            font-size: 14px;
            color: #718096;
        }
        .stats {
            background: #f7fafc;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #4299e1;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
        }
        .stat-item {
            text-align: center;
        }
        .stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #2d3748;
        }
        .stat-label {
            font-size: 10px;
            color: #718096;
            text-transform: uppercase;
        }
        .mood-day {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        .day-header {
            background: #4a5568;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .mood-entry {
            padding: 8px;
            border-left: 3px solid #e2e8f0;
            margin-bottom: 5px;
            background: #f8f9fa;
        }
        .mood-entry:hover {
            background: #edf2f7;
        }
        .mood-time {
            font-weight: bold;
            color: #2d3748;
            display: inline-block;
            width: 50px;
        }
        .mood-value {
            font-weight: bold;
            display: inline-block;
            width: 40px;
            text-align: center;
            padding: 2px 6px;
            border-radius: 12px;
            margin: 0 10px;
        }
        .mood-low { background-color: #fed7d7; color: #c53030; }
        .mood-medium { background-color: #feebcb; color: #dd6b20; }
        .mood-high { background-color: #c6f6d5; color: #276749; }
        .mood-comment {
            color: #4a5568;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #718096;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Дневник настроения</h1>
        <div class="subtitle">Список записей настроения</div>
        <div class="subtitle">Создано: {{ $exportDate->format('d.m.Y H:i') }}</div>
    </div>

    <div class="stats">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-value">{{ $stats['total_entries'] }}</div>
                <div class="stat-label">Всего записей</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $stats['total_days'] }}</div>
                <div class="stat-label">Дней отслежено</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ number_format($stats['average_mood'], 1) }}/9</div>
                <div class="stat-label">Среднее настроение</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $stats['max_mood'] }}/9 - {{ $stats['min_mood'] }}/9</div>
                <div class="stat-label">Макс - Мин</div>
            </div>
        </div>
        <div style="text-align: center; margin-top: 10px; font-size: 11px; color: #4a5568;">
            Период: {{ $stats['period_start']->format('d.m.Y') }} - {{ $stats['period_end']->format('d.m.Y') }}
        </div>
    </div>

    @foreach($moods->groupBy(function($item) {
        return $item->created_at->format('Y-m-d');
    }) as $date => $dailyMoods)
    <div class="mood-day">
        <div class="day-header">
            {{ \Carbon\Carbon::parse($date)->format('d F Y') }}
            <span style="float: right;">
                Среднее: {{ number_format($dailyMoods->avg('mood.value'), 1) }}/9
            </span>
        </div>
        
        @foreach($dailyMoods->sortBy('created_at') as $mood)
            @php
                $moodClass = $mood->mood->value >= 7 ? 'mood-high' : 
                            ($mood->mood->value >= 5 ? 'mood-medium' : 'mood-low');
            @endphp
            <div class="mood-entry">
                <span class="mood-time">{{ $mood->created_at->format('H:i') }}</span>
                <span class="mood-value {{ $moodClass }}">{{ $mood->mood->value }}/9</span>
                <span class="mood-comment">{{ $mood->comment ?? 'Без комментария' }}</span>
            </div>
        @endforeach
    </div>
    @endforeach

    <div class="footer">
        Создано в Психиатр Онлайн • {{ config('app.name') }} • Страница <span class="page-number"></span>
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $text = "Страница {PAGE_NUM} из {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("DejaVu Sans");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 35;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
</body>
</html>