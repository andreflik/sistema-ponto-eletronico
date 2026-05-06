<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('time_entry_adjustment_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->foreignId('time_entry_id')
                ->nullable()
                ->constrained('time_entries')
                ->nullOnDelete();

            $table->date('work_date');

            $table->timestamp('requested_clock_in')->nullable();
            $table->timestamp('requested_break_start')->nullable();
            $table->timestamp('requested_break_end')->nullable();
            $table->timestamp('requested_clock_out')->nullable();

            $table->text('reason');

            $table->string('status')->default('pending');

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();
            $table->text('admin_note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('time_entry_adjustment_requests');
    }
};
