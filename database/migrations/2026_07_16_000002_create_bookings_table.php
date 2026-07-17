<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->enum('meeting_type', ['online', 'onsite'])->default('online');
            $table->date('date');
            $table->time('time');
            $table->text('comments')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'rescheduled'])->default('pending');
            $table->string('google_calendar_event_id')->nullable();
            $table->string('google_meet_link')->nullable();
            $table->string('management_token', 64)->unique();
            $table->timestamp('reminder_24h_sent_at')->nullable();
            $table->timestamp('reminder_1h_sent_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();

            $table->index(['date', 'time', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
