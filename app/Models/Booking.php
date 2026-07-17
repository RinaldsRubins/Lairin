<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Booking extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'company',
        'email',
        'phone',
        'service_id',
        'meeting_type',
        'date',
        'time',
        'comments',
        'status',
        'google_calendar_event_id',
        'google_meet_link',
        'management_token',
        'reminder_24h_sent_at',
        'reminder_1h_sent_at',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'reminder_24h_sent_at' => 'datetime',
            'reminder_1h_sent_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {
            if (empty($booking->management_token)) {
                $booking->management_token = Str::random(64);
            }
            if (empty($booking->status)) {
                $booking->status = 'pending';
            }
        });
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getScheduledAtAttribute(): \Carbon\Carbon
    {
        return \Carbon\Carbon::parse("{$this->date->format('Y-m-d')} {$this->time}");
    }

    public function isCancellable(): bool
    {
        return in_array($this->status, ['pending', 'confirmed'], true)
            && $this->scheduled_at->isFuture();
    }

    public function managementUrl(): string
    {
        return route('booking.manage', ['token' => $this->management_token]);
    }
}
