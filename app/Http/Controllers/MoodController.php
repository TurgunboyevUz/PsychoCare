<?php
// App\Http\Controllers\MoodController.php

namespace App\Http\Controllers;

use App\Models\UserMood;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MoodController extends Controller
{
    public function mood(Request $request, $hash)
    {
        $data                     = base64_decode($hash);
        list($user_id, $datetime) = explode('-', $data);

        $moods = UserMood::where('tele_user_id', $user_id)
            ->with('mood')
            ->get();

        $moodDataForJs = $moods->map(function ($mood) {
            return [
                'date'    => $mood->created_at,
                'value'   => $mood->mood->value,
                'comment' => $mood->comment,
                'emoji'   => $mood->mood->emoji_label,
            ];
        });

        return view('graph', [
            'moods'         => $moods,
            'moodDataForJs' => $moodDataForJs,
            'hash'          => $hash, // Add this line
            'user_id'       => $user_id,
        ]);
    }

    public function exportMoodListPDF($hash)
    {
        try {
            $data                     = base64_decode($hash);
            list($user_id, $datetime) = explode('-', $data);

            $moods = UserMood::where('tele_user_id', $user_id)
                ->with('mood')
                ->orderBy('created_at', 'desc')
                ->get();

            if ($moods->isEmpty()) {
                return response()->json(['error' => 'No mood data found'], 404);
            }

            $stats = $this->calculateMoodStats($moods);

            $pdf = PDF::loadView('exports.mood-list', [
                'moods'      => $moods,
                'stats'      => $stats,
                'exportDate' => now(),
            ]);

            return $pdf->download('mood-list-' . now()->format('Y-m-d') . '.pdf');

        } catch (\Exception $e) {
            Log::error('PDF Export Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to generate PDF'], 500);
        }
    }

    public function exportFullReportPDF($hash)
    {
        try {
            $data                     = base64_decode($hash);
            list($user_id, $datetime) = explode('-', $data);

            $moods = UserMood::where('tele_user_id', $user_id)
                ->with('mood')
                ->orderBy('created_at', 'asc')
                ->get();

            if ($moods->isEmpty()) {
                return response()->json(['error' => 'No mood data found'], 404);
            }

            $stats      = $this->calculateMoodStats($moods);
            $chartImage = $this->generateMoodChartImage($moods);

            $pdf = PDF::loadView('exports.full-report', [
                'moods'      => $moods,
                'stats'      => $stats,
                'chartImage' => $chartImage,
                'exportDate' => now(),
            ]);

            return $pdf->download('mood-full-report-' . now()->format('Y-m-d') . '.pdf');

        } catch (\Exception $e) {
            Log::error('PDF Export Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to generate PDF'], 500);
        }
    }

    private function generateMoodChartImage($moods)
    {
        $dailyAverages = $this->calculateDailyAveragesForPDF($moods);

        if (empty($dailyAverages) || count($dailyAverages) < 2) {
            return '<div class="no-data">Недостаточно данных для построения графика (требуется минимум 2 дня)</div>';
        }

        return $this->generateSimpleChart($dailyAverages);
    }

    private function generateSimpleChart($dailyAverages)
    {
        $maxValue    = 9;
        $chartHeight = 150;
        $chartWidth  = 500;

        $html = '<div class="simple-chart">';

        // Y-axis labels
        $html .= '<div class="chart-y-axis">';
        for ($i = 9; $i >= 0; $i--) {
            $top = (($maxValue - $i) / $maxValue) * ($chartHeight - 20);
            $html .= '<div style="position: absolute; top: ' . $top . 'px; left: 2px; font-size: 9px; color: #666;">' . $i . '</div>';
        }
        $html .= '</div>';

        // X-axis labels
        $html .= '<div class="chart-x-axis">';
        $pointCount = count($dailyAverages);
        $pointWidth = ($chartWidth - 40) / ($pointCount - 1);

        foreach ($dailyAverages as $index => $day) {
            $left = 40 + ($index * $pointWidth);
            $html .= '<div style="position: absolute; left: ' . ($left - 10) . 'px; top: 2px; font-size: 8px; color: #666; transform: rotate(-45deg); transform-origin: left top; width: 20px;">' . $day['label'] . '</div>';
        }
        $html .= '</div>';

        // Grid lines
        $html .= '<div class="chart-grid">';
        for ($i = 0; $i <= 9; $i++) {
            $top = ($i / $maxValue) * ($chartHeight - 20);
            $html .= '<div style="position: absolute; top: ' . $top . 'px; left: 0; right: 0; border-top: 1px solid #e0e0e0;"></div>';
        }
        $html .= '</div>';

        // Chart line and points
        $html .= '<div class="chart-line">';

        $points = [];
        foreach ($dailyAverages as $index => $day) {
            $x        = $index * $pointWidth;
            $y        = (($maxValue - $day['value']) / $maxValue) * ($chartHeight - 20);
            $points[] = ['x' => $x, 'y' => $y, 'value' => $day['value']];

            // Point
            $color = $this->getMoodColor($day['value']);
            $html .= '<div class="chart-point" style="left: ' . $x . 'px; top: ' . $y . 'px; background: ' . $color . ';"></div>';

            // Value label
            $html .= '<div class="chart-label" style="left: ' . ($x - 10) . 'px; top: ' . ($y - 15) . 'px; width: 20px; font-weight: bold; color: #333;">' . $day['value'] . '</div>';
        }

        // Draw lines between points
        for ($i = 0; $i < count($points) - 1; $i++) {
            $x1 = $points[$i]['x'];
            $y1 = $points[$i]['y'];
            $x2 = $points[$i + 1]['x'];
            $y2 = $points[$i + 1]['y'];

            $length = sqrt(pow($x2 - $x1, 2) + pow($y2 - $y1, 2));
            $angle  = atan2($y2 - $y1, $x2 - $x1) * 180 / pi();

            $html .= '<div style="position: absolute; left: ' . $x1 . 'px; top: ' . $y1 . 'px; width: ' . $length . 'px; height: 2px; background: #ff9900; transform: rotate(' . $angle . 'deg); transform-origin: left center;"></div>';
        }

        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    private function getMoodColor($value)
    {
        if ($value >= 7) {
            return '#22c55e';
        }
        // green
        if ($value >= 5) {
            return '#eab308';
        }
                          // yellow
        return '#ef4444'; // red
    }

    private function calculateDailyAveragesForPDF($moods)
    {
        $groupedByDay = $moods->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        });

        $dailyAverages = [];

        foreach ($groupedByDay as $date => $dailyMoods) {
            $average         = $dailyMoods->avg('mood.value');
            $dailyAverages[] = [
                'label' => \Carbon\Carbon::parse($date)->format('d.m'),
                'value' => round($average, 1),
                'date'  => $date,
                'count' => $dailyMoods->count(),
            ];
        }

        // Sort by date
        usort($dailyAverages, function ($a, $b) {
            return strcmp($a['date'], $b['date']);
        });

        return $dailyAverages;
    }

    private function calculateMoodStats($moods)
    {
        $values = $moods->pluck('mood.value')->toArray();

        return [
            'total_entries' => $moods->count(),
            'total_days'    => $moods->groupBy(function ($item) {
                return $item->created_at->format('Y-m-d');
            })->count(),
            'average_mood'  => $moods->avg('mood.value'),
            'max_mood'      => max($values),
            'min_mood'      => min($values),
            'period_start'  => $moods->min('created_at'),
            'period_end'    => $moods->max('created_at'),
        ];
    }
}
