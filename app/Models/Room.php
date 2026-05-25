<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'floor',
        'monthly_rent',
        'occupancy_limit',
        'notes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'monthly_rent' => 'decimal:2',
            'occupancy_limit' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function tenants(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function tenantBills(): HasMany
    {
        return $this->hasMany(TenantBill::class);
    }

    public function meterReadings(): HasMany
    {
        return $this->hasMany(MeterReading::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }
}
