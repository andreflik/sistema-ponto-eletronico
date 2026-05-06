<?php

namespace App\Http\Controllers;

use App\Models\TimeEntry;
use App\Models\TimeEntryAdjustmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeEntryAdjustmentRequestController extends Controller
{
    public function create()
    {
        return view('time_entries.adjustments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'work_date' => ['required', 'date'],
            'requested_clock_in' => ['nullable', 'date_format:H:i'],
            'requested_break_start' => ['nullable', 'date_format:H:i'],
            'requested_break_end' => ['nullable', 'date_format:H:i'],
            'requested_clock_out' => ['nullable', 'date_format:H:i'],
            'reason' => ['required', 'string', 'min:10'],
        ]);

        $existingEntry = TimeEntry::where('user_id', Auth::id())
            ->where('work_date', $validated['work_date'])
            ->first();

        TimeEntryAdjustmentRequest::create([
            'user_id' => Auth::id(),
            'time_entry_id' => $existingEntry?->id,
            'work_date' => $validated['work_date'],
            'requested_clock_in' => $this->combineDateAndTime($validated['work_date'], $validated['requested_clock_in'] ?? null),
            'requested_break_start' => $this->combineDateAndTime($validated['work_date'], $validated['requested_break_start'] ?? null),
            'requested_break_end' => $this->combineDateAndTime($validated['work_date'], $validated['requested_break_end'] ?? null),
            'requested_clock_out' => $this->combineDateAndTime($validated['work_date'], $validated['requested_clock_out'] ?? null),
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        return redirect()
            ->route('ponto.index')
            ->with('success', 'Solicitação de ajuste enviada para aprovação.');
    }

    private function combineDateAndTime(string $date, ?string $time): ?string
    {
        if (!$time) {
            return null;
        }

        return $date . ' ' . $time . ':00';
    }
}
