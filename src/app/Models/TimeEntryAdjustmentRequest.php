<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimeEntryAdjustmentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'time_entry_id',
        'work_date',
        'requested_clock_in',
        'requested_break_start',
        'requested_break_end',
        'requested_clock_out',
        'reason',
        'status',
        'approved_by',
        'approved_at',
        'admin_note',
    ];

    protected $casts = [
        'work_date' => 'date',
        'requested_clock_in' => 'datetime',
        'requested_break_start' => 'datetime',
        'requested_break_end' => 'datetime',
        'requested_clock_out' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function timeEntry()
    {
        return $this->belongsTo(TimeEntry::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
