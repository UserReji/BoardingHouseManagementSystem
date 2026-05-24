<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GCashAccount extends Model
{
    use HasFactory;

    protected $table = 'gcash_accounts';

    protected $fillable = [
        'account_name',
        'account_number',
        'qr_path',
        'instructions',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
