<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('time_entries', function (Blueprint $table) {
            $table->date('work_date')->nullable()->after('user_id');
        });

        DB::table('time_entries')->update([
            'work_date' => DB::raw('DATE(created_at)')
        ]);

        Schema::table('time_entries', function (Blueprint $table) {
            $table->date('work_date')->nullable(false)->change();
            $table->unique(['user_id', 'work_date']);
        });
    }

    public function down(): void
    {
        Schema::table('time_entries', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'work_date']);
            $table->dropColumn('work_date');
        });
    }
};
