<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeEntry extends Model
{
    protected $fillable = [
        'user_id',
        'wordk_date',
        'clock_in',
        'break_start',
        'break_end',
        'clock_out',
    ];

    protected $casts = [
        'work_date' => 'date',
        'clock_in' => 'datetime',
        'break_start' => 'datetime',
        'break_end' => 'datetime',
        'clock_out' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getWorkedMinutesAttribute(): int
    {
        if (!$this->clock_in || !$this->clock_out) {
            return 0;
        }

        $totalMinutes = $this->clock_in->diffInMinutes($this->clock_out);

        if ($this->break_start && $this->break_end) {
            $breakMinutes = $this->break_start->diffInMinutes($this->break_end);
            $totalMinutes -= $breakMinutes;
        }

        return max($totalMinutes, 0);
    }

    public function getWorkedHoursAttribute(): string
    {
        $minutes = $this->worked_minutes;

        if ($minutes <= 0) {
            return '--:--';
        }

        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        return sprintf('%02d:%02d', $hours, $remainingMinutes);
    }
}
