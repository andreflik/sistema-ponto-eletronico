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
}
