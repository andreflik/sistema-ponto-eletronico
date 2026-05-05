<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimeEntry;
use Illuminate\Http\Request;

class TimeEntryAdminController extends Controller
{
    public function index()
    {
        $entries = TimeEntry::with('user')
            ->orderByDesc('work_date')
            ->paginate(20);

        return view('admin.time_entries.index', compact('entries'));
    }
}
