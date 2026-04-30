<?php

namespace App\Http\Controllers;

use App\Models\TimeEntry;
use Illuminate\Support\Facades\Auth;

class TimeEntryController extends Controller
{
    public function index()
    {
        $todayEntry = $this->getTodayEntry();

        $entries = TimeEntry::where('user_id', Auth::id())
            ->orderByDesc('work_date')
            ->paginate(10);

        return view('time_entries.index', compact('entries', 'todayEntry'));
    }

    private function getTodayEntry()
    {
        $entry = TimeEntry::where('user_id', Auth::id())
            ->where('work_date', now()->toDateString())
            ->first();

        if ($entry) {
            return $entry;
        }

        $entry = new TimeEntry();
        $entry->user_id = Auth::id();
        $entry->work_date = now()->toDateString();
        $entry->clock_in = null;
        $entry->break_start = null;
        $entry->break_end = null;
        $entry->clock_out = null;
        $entry->save();

        return $entry;
    }

    public function clockIn()
    {
        $entry = $this->getTodayEntry();

        if ($entry->clock_in) {
            return back()->with('error', 'Entrada já registrada hoje.');
        }

        $entry->update([
            'clock_in' => now(),
        ]);

        return back()->with('success', 'Entrada registrada com sucesso.');
    }

    public function breakStart()
    {
        $entry = $this->getTodayEntry();

        if (!$entry->clock_in) {
            return back()->with('error', 'Você precisa registrar a entrada primeiro.');
        }

        if ($entry->break_start) {
            return back()->with('error', 'Início do intervalo já registrado hoje.');
        }

        $entry->update([
            'break_start' => now(),
        ]);

        return back()->with('success', 'Início do intervalo registrado.');
    }

    public function breakEnd()
    {
        $entry = $this->getTodayEntry();

        if (!$entry->break_start) {
            return back()->with('error', 'Você precisa iniciar o intervalo primeiro.');
        }

        if ($entry->break_end) {
            return back()->with('error', 'Fim do intervalo já registrado hoje.');
        }

        $entry->update([
            'break_end' => now(),
        ]);

        return back()->with('success', 'Fim do intervalo registrado.');
    }

    public function clockOut()
    {
        $entry = $this->getTodayEntry();

        if (!$entry->clock_in) {
            return back()->with('error', 'Você precisa registrar a entrada primeiro.');
        }

        if ($entry->break_start && !$entry->break_end) {
            return back()->with('error', 'Você precisa finalizar o intervalo antes de sair.');
        }

        if ($entry->clock_out) {
            return back()->with('error', 'Saída já registrada hoje.');
        }

        $entry->update([
            'clock_out' => now(),
        ]);

        return back()->with('success', 'Saída registrada com sucesso.');
    }
}
