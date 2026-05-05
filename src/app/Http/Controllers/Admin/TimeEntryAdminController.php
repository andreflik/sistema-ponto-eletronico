<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimeEntry;
use App\Models\User;
use Illuminate\Http\Request;

class TimeEntryAdminController extends Controller
{
    public function index(Request $request)
    {
        $selectedUserId = $request->input('user_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $users = User::orderBy('name')->get();

        $entries = TimeEntry::with('user')
            ->when($selectedUserId, function ($query) use ($selectedUserId) {
                $query->where('user_id', $selectedUserId);
            })
            ->when($startDate, function ($query) use ($startDate) {
                $query->whereDate('work_date', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->whereDate('work_date', '<=', $endDate);
            })
            ->orderByDesc('work_date')
            ->paginate(20)
            ->withQueryString();

        return view('admin.time_entries.index', compact(
            'entries',
            'users',
            'selectedUserId',
            'startDate',
            'endDate'
        ));
    }
}
