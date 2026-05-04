<?php

namespace Database\Seeders;

use App\Models\TimeEntry;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TimeEntrySeeder extends Seeder
{
    public function run(): void
    {
        $startDate = Carbon::create(2026, 1, 3);
        $endDate = Carbon::create(2026, 5, 4);

        while ($startDate <= $endDate) {
            if ($startDate->isWeekend()) {
                $startDate->addDay();
                continue;
            }

            $clockIn = $startDate->copy()->setTime(8, rand(0, 20));
            $breakStart = $startDate->copy()->setTime(12, rand(0, 10));
            $breakEnd = $startDate->copy()->setTime(13, rand(0, 10));
            $clockOut = $startDate->copy()->setTime(17, rand(30, 59));

            TimeEntry::updateOrCreate(
                [
                    'user_id' => 1,
                    'work_date' => $startDate->toDateString(),
                ],
                [
                    'clock_in' => $clockIn,
                    'break_start' => $breakStart,
                    'break_end' => $breakEnd,
                    'clock_out' => $clockOut,
                ]
            );

            $startDate->addDay();
        }
    }
}
