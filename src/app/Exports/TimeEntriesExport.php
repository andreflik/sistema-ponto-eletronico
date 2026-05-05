<?php

namespace App\Exports;

use App\Models\TimeEntry;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TimeEntriesExport implements FromView
{
    protected $entries;

    public function __construct($entries)
    {
        $this->entries = $entries;
    }

    public function view(): View
    {
        return view('admin.time_entries.excel', [
            'entries' => $this->entries
        ]);
    }
}
