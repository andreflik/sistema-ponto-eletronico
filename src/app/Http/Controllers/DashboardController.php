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

        foreach ($entries as $entry) {
            $labels[] = Carbon::parse($entry->work_date)->format('d/m');

            $minutes = $entry->worked_minutes;
            $hours = $minutes / 60;

            $data[] = round($hours, 2);
        }

        return view('dashboard', compact('labels', 'data'));
    }
}
