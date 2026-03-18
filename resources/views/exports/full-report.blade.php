<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Дневник настроения - Полный отчет</title>
    <style>
        /* Simple, PDF-compatible CSS */
        @font-face {
            font-family: 'DejaVu Sans';
            src: url('{{ asset('sans-fonts/DejaVuSans.ttf') }}') format('truetype');
        }
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            line-height: 1.3;
            color: #000000;
            margin: 0;
            padding: 15px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333333;
        }
        
        .header h1 {
            font-size: 20px;
            margin: 0 0 5px 0;
            color: #000000;
        }
        
        .header .subtitle {
            font-size: 12px;
            color: #666666;
            margin: 2px 0;
        }
        
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        
        .section-title {
            background: #444444;
            color: white;
            padding: 6px 10px;
            margin-bottom: 10px;
            font-size: 14px;
            font-weight: bold;
        }
        
        .stats-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        .stats-table td {
            padding: 8px;
            text-align: center;
            border: 1px solid #dddddd;
            vertical-align: top;
        }
        
        .stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #000000;
            display: block;
        }
        
        .stat-label {
            font-size: 10px;
            color: #666666;
            text-transform: uppercase;
            display: block;
        }
        
        .analysis {
            background: #f9f9f9;
            padding: 12px;
            border: 1px solid #dddddd;
            margin: 15px 0;
            border-left: 4px solid #ff9900;
        }
        
        .analysis-title {
            font-weight: bold;
            color: #cc6600;
            margin-bottom: 8px;
            font-size: 13px;
        }
        
        .chart-container {
            margin: 15px 0;
            padding: 10px;
            background: white;
            border: 1px solid #dddddd;
        }
        
        .chart-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
            color: #000000;
            font-size: 13px;
        }
        
        .mood-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        
        .mood-table th {
            background: #444444;
            color: white;
            padding: 6px 8px;
            text-align: left;
            font-size: 11px;
            border: 1px solid #333333;
        }
        
        .mood-table td {
            padding: 5px 8px;
            border: 1px solid #dddddd;
            font-size: 11px;
            vertical-align: top;
        }
        
        .day-header {
            background: #eeeeee;
            font-weight: bold;
            color: #000000;
        }
        
        .mood-value {
            font-weight: bold;
            text-align: center;
            display: inline-block;
            padding: 1px 6px;
            border-radius: 8px;
            font-size: 10px;
            min-width: 30px;
        }
        
        .mood-low { background-color: #ffcccc; color: #990000; }
        .mood-medium { background-color: #fff0cc; color: #996600; }
        .mood-high { background-color: #ccffcc; color: #006600; }
        
        .footer {
            margin-top: 25px;
            text-align: center;
            font-size: 9px;
            color: #666666;
            border-top: 1px solid #dddddd;
            padding-top: 8px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .no-data {
            text-align: center;
            padding: 20px;
            color: #666666;
            font-style: italic;
        }
        
        /* Simple chart styles */
        .simple-chart {
            width: 100%;
            height: 150px;
            position: relative;
            border: 1px solid #dddddd;
            background: #f8f8f8;
            margin: 10px 0;
        }
        
        .chart-grid {
            position: absolute;
            top: 0;
            left: 40px;
            right: 0;
            bottom: 20px;
        }
        
        .chart-y-axis {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 20px;
            width: 40px;
            border-right: 1px solid #dddddd;
        }
        
        .chart-x-axis {
            position: absolute;
            left: 40px;
            right: 0;
            bottom: 0;
            height: 20px;
            border-top: 1px solid #dddddd;
        }
        
        .chart-line {
            position: absolute;
            left: 40px;
            right: 0;
            top: 0;
            bottom: 20px;
        }
        
        .chart-point {
            position: absolute;
            width: 8px;
            height: 8px;
            background: #ff9900;
            border: 2px solid white;
            border-radius: 50%;
            margin-left: -4px;
            margin-top: -4px;
        }
        
        .chart-label {
            position: absolute;
            font-size: 9px;
            color: #666666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Дневник настроения - Полный отчет</h1>
        <div class="subtitle">Подробная аналитика и история настроений</div>
        <div class="subtitle">Создано: {{ $exportDate->format('d.m.Y H:i') }}</div>
    </div>

    <div class="section">
        <div class="section-title">Статистика</div>
        
        <table class="stats-table">
            <tr>
                <td>
                    <span class="stat-value">{{ $stats['total_entries'] }}</span>
                    <span class="stat-label">Всего записей</span>
                </td>
                <td>
                    <span class="stat-value">{{ $stats['total_days'] }}</span>
                    <span class="stat-label">Дней отслежено</span>
                </td>
                <td>
                    <span class="stat-value">{{ number_format($stats['average_mood'], 1) }}/9</span>
                    <span class="stat-label">Среднее настроение</span>
                </td>
                <td>
                    <span class="stat-value">{{ $stats['max_mood'] }}/9</span>
                    <span class="stat-label">Максимум</span>
                </td>
                <td>
                    <span class="stat-value">{{ $stats['min_mood'] }}/9</span>
                    <span class="stat-label">Минимум</span>
                </td>
            </tr>
        </table>
        
        <div style="text-align: center; color: #666666; font-size: 11px;">
            Период отслеживания: {{ $stats['period_start']->format('d.m.Y') }} - {{ $stats['period_end']->format('d.m.Y') }}
        </div>
    </div>

    <div class="analysis">
        <div class="analysis-title">Анализ данных:</div>
        <p>• Среднее значение настроения: <strong>{{ number_format($stats['average_mood'], 1) }}/9</strong></p>
        <p>• Диапазон колебаний настроения: от <strong>{{ $stats['min_mood'] }}/9</strong> до <strong>{{ $stats['max_mood'] }}/9</strong></p>
        <p>• Всего дней с записями: <strong>{{ $stats['total_days'] }}</strong> дней</p>
        <p>• Среднее количество записей в день: <strong>{{ number_format($stats['total_entries'] / max($stats['total_days'], 1), 1) }}</strong></p>
        
        @if($stats['average_mood'] >= 7)
        <p>• <strong>Позитивная тенденция:</strong> Преобладают высокие показатели настроения</p>
        @elseif($stats['average_mood'] >= 5)
        <p>• <strong>Стабильное состояние:</strong> Настроение в основном в среднем диапазоне</p>
        @else
        <p>• <strong>Требует внимания:</strong> Наблюдаются низкие показатели настроения</p>
        @endif
    </div>

    <div class="section">
        <div class="section-title">График настроения</div>
        <div class="chart-container">
            <div class="chart-title">Динамика среднего дневного настроения</div>
            
            @if(isset($chartImage) && $chartImage)
                {!! $chartImage !!}
            @else
                <div class="no-data">
                    Недостаточно данных для построения графика
                </div>
            @endif
        </div>
    </div>

    <div class="page-break"></div>

    <div class="section">
        <div class="section-title">Подробная история настроений</div>
        
        @if($moods->count() > 0)
            <table class="mood-table">
                <thead>
                    <tr>
                        <th width="15%">Дата</th>
                        <th width="10%">Время</th>
                        <th width="10%">Настроение</th>
                        <th>Комментарий</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($moods->sortBy('created_at') as $mood)
                    <tr>
                        <td><strong>{{ $mood->created_at->format('d.m.Y') }}</strong></td>
                        <td>{{ $mood->created_at->format('H:i') }}</td>
                        <td style="text-align: center;">
                            @php
                                $moodClass = $mood->mood->value >= 7 ? 'mood-high' : 
                                            ($mood->mood->value >= 5 ? 'mood-medium' : 'mood-low');
                            @endphp
                            <span class="mood-value {{ $moodClass }}">{{ $mood->mood->value }}/9</span>
                        </td>
                        <td>{{ $mood->comment ?? 'Без комментария' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">Нет данных о настроении</div>
        @endif
    </div>

    <div class="footer">
        Полный отчет Yaratilgan vaqti Психиатр Онлайн • {{ config('app.name') }} • Страница <span class="page-number"></span>
    </div>
</body>
</html>