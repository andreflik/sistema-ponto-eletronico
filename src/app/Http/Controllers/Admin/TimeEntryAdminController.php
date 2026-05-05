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

        $users = User::orderBy('name')->get();

        $entries = TimeEntry::with('user')
            ->when($selectedUserId, function ($query) use ($selectedUserId) {
                $query->where('user_id', $selectedUserId);
            })
            ->orderByDesc('work_date')
            ->paginate(20)
            ->withQueryString();

        return view('admin.time_entries.index', compact(
            'entries',
            'users',
            'selectedUserId'
        ));
    }
}
