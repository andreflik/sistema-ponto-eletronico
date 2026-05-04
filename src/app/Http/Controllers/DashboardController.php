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
        $filterType = request('filter_type', 'month');
        $filterDate = request('filter_date', now()->format('Y-m'));

        if ($filterType === 'day') {
            $date = Carbon::parse($filterDate);

            $startDate = $date->copy()->startOfDay();
            $endDate = $date->copy()->endOfDay();
        } elseif ($filterType === 'week') {
            $date = Carbon::parse($filterDate);

            $startDate = $date->copy()->startOfWeek();
            $endDate = $date->copy()->endOfWeek();
        } elseif ($filterType === 'year') {
            $date = Carbon::createFromDate($filterDate, 1, 1);

            $startDate = $date->copy()->startOfYear();
            $endDate = $date->copy()->endOfYear();
        } else {
            $filterType = 'month';
            $date = Carbon::parse($filterDate . '-01');

            $startDate = $date->copy()->startOfMonth();
            $endDate = $date->copy()->endOfMonth();
        }

        $entries = TimeEntry::where('user_id', Auth::id())
            ->whereBetween('work_date', [
                $startDate->toDateString(),
                $endDate->toDateString(),
            ])
            ->orderBy('work_date')
            ->get();

        $labels = [];
        $data = [];

        $totalMinutes = 0;
        $daysWorked = 0;

        foreach ($entries as $entry) {
            $labels[] = Carbon::parse($entry->work_date)->format('d/m/Y');

            $minutes = $entry->worked_minutes;
            $data[] = round($minutes / 60, 2);

            if ($minutes > 0) {
                $totalMinutes += $minutes;
                $daysWorked++;
            }
        }

        $todayEntry = TimeEntry::where('user_id', Auth::id())
            ->where('work_date', now()->toDateString())
            ->first();

        $todayMinutes = $todayEntry ? $todayEntry->worked_minutes : 0;

        $weeklyMinutes = TimeEntry::where('user_id', Auth::id())
            ->whereBetween('work_date', [
                now()->startOfWeek()->toDateString(),
                now()->endOfWeek()->toDateString(),
            ])
            ->get()
            ->sum('worked_minutes');

        return view('dashboard', [
            'labels' => $labels,
            'data' => $data,
            'todayHours' => $this->formatMinutes($todayMinutes),
            'weeklyHours' => $this->formatMinutes($weeklyMinutes),
            'periodHours' => $this->formatMinutes($totalMinutes),
            'daysWorked' => $daysWorked,
            'averageHours' => $daysWorked ? $this->formatMinutes($totalMinutes / $daysWorked) : '00:00',
            'filterType' => $filterType,
            'filterDate' => $filterDate,
        ]);
    }

    private function formatMinutes($minutes): string
    {
        $hours = floor($minutes / 60);
        $remaining = $minutes % 60;

        return sprintf('%02d:%02d', $hours, $remaining);
    }
}
