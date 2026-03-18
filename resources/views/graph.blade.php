<!-- graph.blade.php -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@2.0.0/dist/chartjs-plugin-zoom.min.js"></script>
    <script src="https://unpkg.com/dayjs@1/dayjs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
      /* Keep all your existing styles */
      .mood-low {
        background-color: #fef2f2;
        color: #dc2626;
      }

      .mood-medium {
        background-color: #fffbeb;
        color: #d97706;
      }

      .mood-high {
        background-color: #f0fdf4;
        color: #16a34a;
      }

      #chart-container {
        background: white;
        border-radius: 12px;
        padding: 20px;
      }

      .analytics-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
      }

      .zoom-controls {
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        gap: 5px;
        z-index: 10;
      }

      .zoom-btn {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 4px;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-weight: bold;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      }

      .zoom-btn:hover {
        background: #f9fafb;
      }

      .chart-wrapper {
        position: relative;
      }

      .export-menu {
        position: relative;
        display: inline-block;
      }

      .export-dropdown {
        display: none;
        position: absolute;
        right: 0;
        background-color: white;
        min-width: 200px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        z-index: 1000;
        margin-top: 8px;
        border: 1px solid #e5e7eb;
      }

      .export-dropdown.show {
        display: block;
      }

      .export-dropdown button {
        width: 100%;
        text-align: left;
        padding: 12px 16px;
        border: none;
        background: none;
        cursor: pointer;
        font-size: 14px;
        color: #374151;
        transition: background-color 0.2s;
      }

      .export-dropdown button:hover {
        background-color: #f3f4f6;
      }

      .export-dropdown button:first-child {
        border-radius: 8px 8px 0 0;
      }

      .export-dropdown button:last-child {
        border-radius: 0 0 8px 8px;
      }

      .export-dropdown button:not(:last-child) {
        border-bottom: 1px solid #e5e7eb;
      }

      .loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        justify-content: center;
        align-items: center;
      }

      .loading-overlay.show {
        display: flex;
      }

      .loading-spinner {
        background: white;
        padding: 30px;
        border-radius: 12px;
        text-align: center;
      }

      .spinner {
        border: 4px solid #f3f4f6;
        border-top: 4px solid #3b82f6;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
        margin: 0 auto 15px;
      }

      @keyframes spin {
        0% {
          transform: rotate(0deg);
        }

        100% {
          transform: rotate(360deg);
        }
      }
    </style>
  </head>
  <body class="bg-gray-50 min-h-screen">
    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay">
      <div class="loading-spinner">
        <div class="spinner"></div>
        <p class="text-gray-700 font-medium">Создание отчета...</p>
      </div>
    </div>
    <div class="max-w-6xl mx-auto p-6 space-y-8">
      <!-- Header -->
      <div class="text-center space-y-3">
        <h1 class="text-3xl font-bold text-gray-800">Психиатр Онлайн</h1>
        <p class="text-xl text-gray-600">Дневник настроения</p>
      </div>
      <!-- Analytics Info -->
      <div id="analytics-info" class="bg-white shadow-md rounded-xl p-4 border border-gray-200">
        <div class="flex items-center space-x-2 mb-2">
          <span class="analytics-badge px-3 py-1 rounded-full text-sm font-semibold">Аналитика</span>
          <span id="data-strategy" class="text-gray-700 font-medium">Загрузка данных...</span>
        </div>
        <div id="strategy-description" class="text-sm text-gray-600"></div>
      </div>
      <!-- Statistics Cards -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-blue-50 p-4 rounded-lg text-center border border-blue-100">
          <div class="text-2xl font-bold text-blue-600" id="total-entries">0</div>
          <div class="text-sm text-blue-800">Всего записей</div>
        </div>
        <div class="bg-green-50 p-4 rounded-lg text-center border border-green-100">
          <div class="text-2xl font-bold text-green-600" id="total-days">0</div>
          <div class="text-sm text-green-800">Дней отслежено</div>
        </div>
        <div class="bg-yellow-50 p-4 rounded-lg text-center border border-yellow-100">
          <div class="text-2xl font-bold text-yellow-600" id="max-mood">0</div>
          <div class="text-sm text-yellow-800">Макс. настроение</div>
        </div>
        <div class="bg-red-50 p-4 rounded-lg text-center border border-red-100">
          <div class="text-2xl font-bold text-red-600" id="min-mood">0</div>
          <div class="text-sm text-red-800">Мин. настроение</div>
        </div>
      </div>
      <!-- Chart Section -->
      <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-semibold text-gray-800">График настроения</h2>
          <div class="flex space-x-2">
            <button onclick="resetZoom()" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg shadow transition-all duration-200 flex items-center space-x-2">
              <span>🔄</span>
              <span>Сбросить масштаб</span>
            </button>
            <!-- Export Menu -->
            <div class="export-menu">
              <button onclick="toggleExportMenu()" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow transition-all duration-200 flex items-center space-x-2">
                <span>📥</span>
                <span>Экспорт</span>
                <span>▼</span>
              </button>
              <div id="exportDropdown" class="export-dropdown">
                <button onclick="exportChartPNG()">
                  <span>🖼️</span> Экспорт графика (PNG) </button>
                <button onclick="exportMoodListPDF()">
                  <span>📋</span> Экспорт списка настроений (PDF) </button>
                <button onclick="exportFullReportPDF()">
                  <span>📄</span> Полный отчет (PDF) </button>
              </div>
            </div>
          </div>
        </div>
        <div id="chart-container">
          <div class="text-center mb-4 p-4 bg-gray-50 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-800" id="chart-title">Психиатр Онлайн - Отчет настроения</h3>
            <p class="text-gray-600" id="chart-subtitle">Загрузка данных...</p>
            <p class="text-sm text-gray-500" id="chart-description"></p>
          </div>
          <div class="chart-wrapper">
            <div class="zoom-controls">
              <button class="zoom-btn" onclick="zoomIn()">+</button>
              <button class="zoom-btn" onclick="zoomOut()">-</button>
            </div>
            <div class="w-full h-80">
              <canvas id="moodChart"></canvas>
            </div>
          </div>
          <div class="mt-4 text-sm text-gray-500 text-center">
            <p>Используйте колесико мыши для масштабирования и перетаскивание для перемещения по графику</p>
          </div>
        </div>
      </div>
      <!-- Data Summary -->
      <div class="bg-white shadow-md rounded-xl p-6 border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Сводка данных</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
          <div id="data-summary"></div>
          <div id="aggregation-info"></div>
        </div>
      </div>
      <!-- Detailed History -->
      <div class="bg-white shadow-md rounded-xl p-6 border border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-6 pb-2 border-b border-gray-200">Подробная история настроений</h2>
        <div id="mood-history"> @foreach($moods->groupBy(function($item) { return \Carbon\Carbon::parse($item->created_at)->format('Y-m-d'); }) as $date => $dailyMoods) <div class="mb-8 last:mb-0">
            <div class="flex justify-between items-center mb-3 p-3 bg-gray-50 rounded-lg">
              <h3 class="text-lg font-semibold text-gray-800">{{ \Carbon\Carbon::parse($date)->format('d F Y') }}</h3>
              <div class="text-sm text-gray-600"> Среднее: <span class="font-bold text-yellow-600">{{ number_format($dailyMoods->avg('mood.value'), 1) }}/9</span>
              </div>
            </div>
            <div class="grid gap-2"> @foreach($dailyMoods->sortBy('created_at') as $mood) @php $moodClass = $mood->mood->value >= 7 ? 'mood-high' : ($mood->mood->value >= 5 ? 'mood-medium' : 'mood-low'); @endphp <div class="flex justify-between items-center p-3 hover:bg-gray-50 rounded-lg transition-colors duration-150">
                <div class="flex-1">
                  <p class="text-gray-700">
                    <span class="font-medium text-gray-900 w-16 inline-block">{{ \Carbon\Carbon::parse($mood->created_at)->format('H:i') }}</span> — {{ $mood->comment ?? 'Без комментария' }}
                  </p>
                </div>
                <span class="font-bold px-3 py-1 rounded-full text-sm {{ $moodClass }}">
                  {{ $mood->mood->value }}/9 </span>
              </div> @endforeach </div>
          </div> @endforeach </div>
      </div>
    </div>
    <script>
      let moodChart;
      let allMoodData = @json($moodDataForJs);
      const currentHash = '{{ $hash }}';
      // Data aggregation levels
      const AggregationLevels = {
        PERIOD: 'period',
        DAILY: 'daily',
        HOURLY: 'hourly',
        INDIVIDUAL: 'individual'
      };
      // Close export menu when clicking outside
      document.addEventListener('click', function(event) {
        const exportMenu = document.querySelector('.export-menu');
        const exportDropdown = document.getElementById('exportDropdown');
        if (exportMenu && !exportMenu.contains(event.target)) {
          exportDropdown.classList.remove('show');
        }
      });
      // Toggle export menu
      function toggleExportMenu() {
        event.stopPropagation();
        const dropdown = document.getElementById('exportDropdown');
        dropdown.classList.toggle('show');
      }
      // Show/hide loading overlay
      function showLoading() {
        document.getElementById('loadingOverlay').classList.add('show');
      }

      function hideLoading() {
        document.getElementById('loadingOverlay').classList.remove('show');
      }
      // Export chart as PNG (frontend only)
      async function exportChartPNG() {
        try {
          showLoading();
          document.getElementById('exportDropdown').classList.remove('show');
          const chartContainer = document.getElementById('chart-container');
          const canvas = await html2canvas(chartContainer, {
            scale: 2,
            useCORS: true,
            backgroundColor: '#ffffff'
          });
          canvas.toBlob(function(blob) {
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.download = `mood-chart-${dayjs().format('YYYY-MM-DD')}.png`;
            link.href = url;
            link.click();
            URL.revokeObjectURL(url);
            hideLoading();
          });
        } catch (error) {
          console.error('Error exporting PNG:', error);
          alert('Ошибка при создании PNG.');
          hideLoading();
        }
      }
      // Export mood list PDF via backend
      async function exportMoodListPDF() {
        try {
          showLoading();
          document.getElementById('exportDropdown').classList.remove('show');
          const response = await fetch(`/export/mood-list/${currentHash}`);
          const blob = await response.blob();
          const url = window.URL.createObjectURL(blob);
          const link = document.createElement('a');
          link.href = url;
          link.download = `mood-list-${dayjs().format('YYYY-MM-DD')}.pdf`;
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
          window.URL.revokeObjectURL(url);
          hideLoading();
        } catch (error) {
          console.error('Error exporting mood list PDF:', error);
          alert('Ошибка при создании PDF.');
          hideLoading();
        }
      }
      // Export full report PDF via backend
      async function exportFullReportPDF() {
        try {
          showLoading();
          document.getElementById('exportDropdown').classList.remove('show');
          const response = await fetch(`/export/full-report/${currentHash}`);
          const blob = await response.blob();
          const url = window.URL.createObjectURL(blob);
          const link = document.createElement('a');
          link.href = url;
          link.download = `mood-full-report-${dayjs().format('YYYY-MM-DD')}.pdf`;
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
          window.URL.revokeObjectURL(url);
          hideLoading();
        } catch (error) {
          console.error('Error exporting full report PDF:', error);
          alert('Ошибка при создании PDF.');
          hideLoading();
        }
      }
      // Keep all your existing chart functions (initializeChart, zoomIn, zoomOut, resetZoom, etc.)
      // ... [All your existing chart-related JavaScript functions remain the same] ...
      // Smart data aggregation based on zoom level
      function getAggregatedChartData(visibleRange = null) {
        if (!allMoodData.length) return {
          chartData: [],
          strategy: AggregationLevels.INDIVIDUAL,
          description: 'Нет данных'
        };
        const totalDays = new Set(allMoodData.map(entry => dayjs(entry.date).format('YYYY-MM-DD'))).size;
        const totalEntries = allMoodData.length;
        let strategy, chartData, description;
        // If we have very few days (less than 3), show individual entries
        if (totalDays <= 3) {
          strategy = AggregationLevels.INDIVIDUAL;
          chartData = allMoodData.map(entry => ({
            label: dayjs(entry.date).format('DD.MM HH:mm'),
            value: entry.value,
            date: entry.date,
            type: 'individual',
            entries: 1,
            comment: entry.comment,
            rawEntries: [entry]
          }));
          description = `Показаны все отдельные записи (${totalDays} дней)`;
        }
        // If zoomed in to 1 day or less, show hourly data
        else if (visibleRange && visibleRange.visibleDays <= 1) {
          strategy = AggregationLevels.HOURLY;
          chartData = calculateHourlyAverages(allMoodData, visibleRange.start, visibleRange.end);
          description = `Почасовые данные за ${dayjs(visibleRange.start).format('DD.MM.YYYY')}`;
        }
        // If zoomed in to 7 days or less, show daily data
        else if (visibleRange && visibleRange.visibleDays <= 7) {
          strategy = AggregationLevels.DAILY;
          chartData = calculateDailyAverages(allMoodData, visibleRange.start, visibleRange.end);
          description = `Ежедневные данные за ${Math.round(visibleRange.visibleDays)} дней`;
        }
        // If we have few total days (less than 14), always show daily data
        else if (totalDays <= 14) {
          strategy = AggregationLevels.DAILY;
          chartData = calculateDailyAverages(allMoodData);
          description = `Ежедневные данные за ${totalDays} дней`;
        }
        // For larger datasets, use period aggregation
        else {
          strategy = AggregationLevels.PERIOD;
          chartData = calculatePeriodAverages(allMoodData);
          description = `Данные сгруппированы по периодам (${totalDays} дней)`;
        }
        return {
          strategy,
          chartData,
          description,
          totalDays,
          totalEntries
        };
      }

      function calculateHourlyAverages(moodData, startDate, endDate) {
        const filteredData = moodData.filter(entry => {
          const entryDate = dayjs(entry.date);
          return entryDate.isAfter(dayjs(startDate).subtract(1, 'hour')) && entryDate.isBefore(dayjs(endDate).add(1, 'hour'));
        });
        // If we have very few points in this range, show them individually
        if (filteredData.length <= 10) {
          return filteredData.map(entry => ({
            label: dayjs(entry.date).format('HH:mm'),
            value: entry.value,
            date: entry.date,
            type: 'individual',
            entries: 1,
            comment: entry.comment,
            rawEntries: [entry]
          })).sort((a, b) => new Date(a.date) - new Date(b.date));
        }
        // Otherwise, do hourly aggregation
        const groupedByHour = filteredData.reduce((acc, entry) => {
          const hourKey = dayjs(entry.date).format('YYYY-MM-DD HH:00');
          if (!acc[hourKey]) {
            acc[hourKey] = {
              values: [],
              entries: []
            };
          }
          acc[hourKey].values.push(entry.value);
          acc[hourKey].entries.push(entry);
          return acc;
        }, {});
        return Object.entries(groupedByHour).map(([hour, data]) => {
          const values = data.values;
          const avgValue = values.reduce((sum, val) => sum + val, 0) / values.length;
          return {
            label: dayjs(hour).format('HH:mm'),
            value: Math.round(avgValue * 10) / 10,
            date: hour,
            type: 'hourly',
            entries: values.length,
            min: Math.min(...values),
            max: Math.max(...values),
            rawEntries: data.entries
          };
        }).sort((a, b) => new Date(a.date) - new Date(b.date));
      }

      function calculateDailyAverages(moodData, startDate = null, endDate = null) {
        let filteredData = moodData;
        if (startDate && endDate) {
          filteredData = moodData.filter(entry => {
            const entryDate = dayjs(entry.date);
            return entryDate.isAfter(dayjs(startDate).subtract(1, 'day')) && entryDate.isBefore(dayjs(endDate).add(1, 'day'));
          });
        }
        const groupedByDay = filteredData.reduce((acc, entry) => {
          const dateKey = dayjs(entry.date).format('YYYY-MM-DD');
          if (!acc[dateKey]) {
            acc[dateKey] = {
              values: [],
              entries: []
            };
          }
          acc[dateKey].values.push(entry.value);
          acc[dateKey].entries.push(entry);
          return acc;
        }, {});
        return Object.entries(groupedByDay).map(([date, data]) => {
          const values = data.values;
          const avgValue = values.reduce((sum, val) => sum + val, 0) / values.length;
          return {
            label: dayjs(date).format('DD MMM'),
            value: Math.round(avgValue * 10) / 10,
            date: date,
            type: 'daily',
            entries: values.length,
            min: Math.min(...values),
            max: Math.max(...values),
            rawEntries: data.entries
          };
        }).sort((a, b) => new Date(a.date) - new Date(b.date));
      }

      function calculatePeriodAverages(moodData) {
        const dailyAverages = calculateDailyAverages(moodData);
        const totalDays = dailyAverages.length;
        // Adjust max data points based on total days
        const maxDataPoints = Math.min(20, Math.max(8, Math.floor(totalDays / 3)));
        const daysPerPeriod = Math.ceil(totalDays / maxDataPoints);
        const periods = [];
        for (let i = 0; i < totalDays; i += daysPerPeriod) {
          const periodDays = dailyAverages.slice(i, i + daysPerPeriod);
          if (periodDays.length === 0) continue;
          const periodAverage = periodDays.reduce((sum, day) => sum + day.value, 0) / periodDays.length;
          const totalEntries = periodDays.reduce((sum, day) => sum + day.entries, 0);
          const startDate = periodDays[0].date;
          const endDate = periodDays[periodDays.length - 1].date;
          periods.push({
            label: dayjs(startDate).format('DD') === dayjs(endDate).format('DD') ? dayjs(startDate).format('DD MMM') : `${dayjs(startDate).format('DD')}-${dayjs(endDate).format('DD MMM')}`,
            value: Math.round(periodAverage * 10) / 10,
            date: startDate,
            type: 'period',
            entries: totalEntries,
            days: periodDays.length,
            dateRange: `${dayjs(startDate).format('DD.MM')}-${dayjs(endDate).format('DD.MM')}`,
            min: Math.min(...periodDays.map(d => d.min)),
            max: Math.max(...periodDays.map(d => d.max))
          });
        }
        return periods;
      }

      function getVisibleDateRange(chart) {
        if (!chart.scales.x) return null;
        const xScale = chart.scales.x;
        const start = xScale.getValueForPixel(xScale.left);
        const end = xScale.getValueForPixel(xScale.right);
        return {
          start: start,
          end: end,
          visibleDays: (end - start) / (1000 * 60 * 60 * 24)
        };
      }

      function calculatePointRadius(aggregatedData) {
        const dataPoints = aggregatedData.chartData.length;
        if (dataPoints <= 10) return 6; // Large points for few data points
        if (dataPoints <= 30) return 5; // Medium points
        if (dataPoints <= 50) return 4; // Smaller points
        if (dataPoints <= 100) return 3; // Even smaller
        return 2; // Very small for dense data
      }

      function updateChart() {
        const ctx = document.getElementById('moodChart').getContext('2d');
        const visibleRange = moodChart ? getVisibleDateRange(moodChart) : null;
        const aggregatedData = getAggregatedChartData(visibleRange);
        if (moodChart) {
          moodChart.destroy();
        }
        document.getElementById('data-strategy').textContent = getStrategyDisplayName(aggregatedData.strategy);
        document.getElementById('strategy-description').textContent = aggregatedData.description;
        document.getElementById('chart-subtitle').textContent = `Период: ${getDateRange(allMoodData)}`;
        document.getElementById('chart-description').textContent = getChartDescription(aggregatedData);
        updateStatistics(allMoodData, aggregatedData);
        // Dynamic point styling based on data density
        const pointRadius = calculatePointRadius(aggregatedData);
        const pointHoverRadius = pointRadius + 2;
        moodChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: aggregatedData.chartData.map(d => d.label),
            datasets: [{
              label: getDatasetLabel(aggregatedData.strategy),
              data: aggregatedData.chartData.map(d => d.value),
              borderColor: '#f59e0b',
              backgroundColor: 'rgba(245, 158, 11, 0.1)',
              borderWidth: 3,
              pointBackgroundColor: '#f59e0b',
              pointBorderColor: '#ffffff',
              pointBorderWidth: 2,
              pointRadius: pointRadius,
              pointHoverRadius: pointHoverRadius,
              tension: 0.4,
              fill: true,
              spanGaps: false
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              y: {
                beginAtZero: true,
                max: 9,
                ticks: {
                  callback: function(value) {
                    return value + '/9';
                  }
                },
                grid: {
                  color: 'rgba(0, 0, 0, 0.1)'
                }
              },
              x: {
                grid: {
                  color: 'rgba(0, 0, 0, 0.1)'
                }
              }
            },
            plugins: {
              legend: {
                display: true,
                position: 'top',
              },
              tooltip: {
                callbacks: {
                  label: function(context) {
                    const dataPoint = aggregatedData.chartData[context.dataIndex];
                    let label = `Настроение: ${dataPoint.value}/9`;
                    if (dataPoint.type === 'daily' || dataPoint.type === 'period') {
                      label += ` (диапазон: ${dataPoint.min}-${dataPoint.max})`;
                    }
                    return label;
                  },
                  afterLabel: function(context) {
                    const dataPoint = aggregatedData.chartData[context.dataIndex];
                    if (dataPoint.type === 'individual') {
                      const time = dayjs(dataPoint.date).format('HH:mm');
                      const comment = dataPoint.comment ? ` - ${dataPoint.comment}` : '';
                      return `Время: ${time}${comment}`;
                    } else if (dataPoint.type === 'hourly') {
                      return `Записей: ${dataPoint.entries}`;
                    } else if (dataPoint.type === 'daily') {
                      return `${dataPoint.entries} записей`;
                    } else if (dataPoint.type === 'period') {
                      return `${dataPoint.entries} записей за ${dataPoint.days} дней`;
                    }
                  }
                }
              },
              zoom: {
                pan: {
                  enabled: true,
                  mode: 'x',
                  modifierKey: 'ctrl',
                },
                zoom: {
                  wheel: {
                    enabled: true,
                  },
                  pinch: {
                    enabled: true
                  },
                  mode: 'x',
                  onZoomComplete: function({
                    chart
                  }) {
                    setTimeout(() => updateChart(), 100);
                  }
                }
              }
            },
            interaction: {
              intersect: false,
              mode: 'index'
            },
            elements: {
              point: {
                hoverBackgroundColor: '#dc2626',
                hoverBorderColor: '#ffffff',
                hoverBorderWidth: 3
              }
            }
          },
          plugins: [ChartZoom]
        });
      }

      function initializeChart() {
        updateChart();
      }

      function zoomIn() {
        if (moodChart) {
          moodChart.zoom(1.1);
          setTimeout(() => updateChart(), 100);
        }
      }

      function zoomOut() {
        if (moodChart) {
          moodChart.zoom(0.9);
          setTimeout(() => updateChart(), 100);
        }
      }

      function resetZoom() {
        if (moodChart) {
          moodChart.resetZoom();
          setTimeout(() => updateChart(), 100);
        }
      }

      function getStrategyDisplayName(strategy) {
        const names = {
          'individual': 'Индивидуальные записи',
          'hourly': 'Почасовые данные',
          'daily': 'Ежедневные данные',
          'period': 'Данные по периодам'
        };
        return names[strategy] || strategy;
      }

      function getDatasetLabel(strategy) {
        const labels = {
          'individual': 'Настроение',
          'hourly': 'Среднее настроение за час',
          'daily': 'Среднее настроение за день',
          'period': 'Среднее настроение за период'
        };
        return labels[strategy] || 'Настроение';
      }

      function getDateRange(moodData) {
        if (!moodData.length) return 'Нет данных';
        const dates = moodData.map(entry => new Date(entry.date));
        const start = dayjs(Math.min(...dates)).format('DD.MM.YYYY');
        const end = dayjs(Math.max(...dates)).format('DD.MM.YYYY');
        return `${start} - ${end}`;
      }

      function getChartDescription(aggregatedData) {
        switch (aggregatedData.strategy) {
          case 'individual':
            return 'Показаны все отдельные записи настроения';
          case 'hourly':
            return 'Показаны почасовые средние значения настроения';
          case 'daily':
            return 'Показаны ежедневные средние значения настроения';
          case 'period':
            return 'Данные сгруппированы по периодам для лучшей читаемости';
          default:
            return 'Показаны данные настроения';
        }
      }

      function updateStatistics(moodData, aggregatedData) {
        const values = moodData.map(entry => entry.value);
        document.getElementById('total-entries').textContent = moodData.length;
        document.getElementById('total-days').textContent = aggregatedData.totalDays;
        document.getElementById('max-mood').textContent = Math.max(...values);
        document.getElementById('min-mood').textContent = Math.min(...values);
        const summary = `
                
					<div class="space-y-2">
						<div class="flex justify-between">
							<span class="text-gray-600">Всего дней:</span>
							<span class="font-semibold">${aggregatedData.totalDays}</span>
						</div>
						<div class="flex justify-between">
							<span class="text-gray-600">Всего записей:</span>
							<span class="font-semibold">${moodData.length}</span>
						</div>
						<div class="flex justify-between">
							<span class="text-gray-600">Среднее настроение:</span>
							<span class="font-semibold">${(values.reduce((a, b) => a + b, 0) / values.length).toFixed(1)}/9</span>
						</div>
					</div>
            `;
        document.getElementById('data-summary').innerHTML = summary;
        const aggregationInfo = `
					<div class="space-y-2">
						<div class="flex justify-between">
							<span class="text-gray-600">Уровень детализации:</span>
							<span class="font-semibold">${getStrategyDisplayName(aggregatedData.strategy)}</span>
						</div>
						<div class="flex justify-between">
							<span class="text-gray-600">Точек на графике:</span>
							<span class="font-semibold">${aggregatedData.chartData.length}</span>
						</div>
						<div class="text-xs text-gray-500 mt-2">
                        ${aggregatedData.description}
                    </div>
					</div>
            `;
        document.getElementById('aggregation-info').innerHTML = aggregationInfo;
      }
      // Initialize the application
      document.addEventListener('DOMContentLoaded', function() {
        // Check if we have few days and should start with individual points
        const totalDays = new Set(allMoodData.map(entry => dayjs(entry.date).format('YYYY-MM-DD'))).size;
        if (totalDays <= 3) {
          // Force initial view to show individual points
          setTimeout(() => {
            initializeChart();
            // Zoom in to show details if we have few points
            if (allMoodData.length <= 20) {
              setTimeout(() => {
                if (moodChart) {
                  moodChart.resetZoom(); // Ensure we're at the right zoom level
                }
              }, 500);
            }
          }, 100);
        } else {
          initializeChart();
        }
      });
    </script>
  </body>
</html>