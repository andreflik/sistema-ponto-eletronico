<?php

namespace App\Http\Controllers;

use App\Models\TimeEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $entries = TimeEntry::where('user_id', Auth::id())
            ->orderBy('work_date')
            ->get();

        $labels = [];
        $data = [];

        $totalMinutes = 0;
        $daysWorked = 0;

        foreach ($entries as $entry) {
            $labels[] = \Carbon\Carbon::parse($entry->work_date)->format('d/m');

            $minutes = $entry->worked_minutes;
            $hours = $minutes / 60;

            $data[] = round($hours, 2);

            if ($minutes > 0) {
                $totalMinutes += $minutes;
                $daysWorked++;
            }
        }

        $today = $entries->last();
        $todayMinutes = $today ? $today->worked_minutes : 0;

        $weeklyMinutes = $entries
            ->filter(fn($e) => \Carbon\Carbon::parse($e->work_date)->isCurrentWeek())
            ->sum('worked_minutes');

        return view('dashboard', [
            'labels' => $labels,
            'data' => $data,
            'todayHours' => $this->formatMinutes($todayMinutes),
            'weeklyHours' => $this->formatMinutes($weeklyMinutes),
            'daysWorked' => $daysWorked,
            'averageHours' => $daysWorked ? $this->formatMinutes($totalMinutes / $daysWorked) : '00:00',
        ]);
    }

    private function formatMinutes($minutes): string
    {
        $hours = floor($minutes / 60);
        $remaining = $minutes % 60;

        return sprintf('%02d:%02d', $hours, $remaining);
    }
}
