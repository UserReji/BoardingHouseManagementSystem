<?php

namespace App\Models;

use App\Enums\BillStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TenantBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'billing_period_id',
        'rent_amount',
        'electricity_amount',
        'water_amount',
        'other_charges',
        'discount_amount',
        'amount_paid',
        'status',
        'due_at',
        'notes',
    ];

    protected $appends = [
        'total_amount',
        'balance',
    ];

    protected function casts(): array
    {
        return [
            'rent_amount' => 'decimal:2',
            'electricity_amount' => 'decimal:2',
            'water_amount' => 'decimal:2',
            'other_charges' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'amount_paid' => 'decimal:2',
            'status' => BillStatus::class,
            'due_at' => 'date',
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

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }

    public function getTotalAmountAttribute(): float
    {
        return round(
            (float) $this->rent_amount
            + (float) $this->electricity_amount
            + (float) $this->water_amount
            + (float) $this->other_charges
            - (float) $this->discount_amount,
            2
        );
    }

    public function getBalanceAttribute(): float
    {
        return max(0, round($this->total_amount - (float) $this->amount_paid, 2));
    }
}
