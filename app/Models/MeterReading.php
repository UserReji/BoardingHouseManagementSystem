<?php

namespace App\Models;

use App\Enums\MeterType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeterReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'billing_period_id',
        'type',
        'previous_reading',
        'current_reading',
        'rate',
        'amount',
        'photo_path',
        'read_at',
        'notes',
    ];

    protected $appends = [
        'usage',
    ];

    protected function casts(): array
    {
        return [
            'type' => MeterType::class,
            'previous_reading' => 'decimal:2',
            'current_reading' => 'decimal:2',
            'rate' => 'decimal:2',
            'amount' => 'decimal:2',
            'read_at' => 'date',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function billingPeriod(): BelongsTo
    {
        return $this->belongsTo(BillingPeriod::class);
    }

    public function getUsageAttribute(): float
    {
        return max(0, round((float) $this->current_reading - (float) $this->previous_reading, 2));
    }
}
