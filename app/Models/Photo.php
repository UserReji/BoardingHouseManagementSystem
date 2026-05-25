<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'room_id',
        'uploaded_by',
        'title',
        'description',
        'path',
        'taken_at',
        'is_featured',
        'visibility',
    ];

    protected function casts(): array
    {
        return [
            'taken_at' => 'date',
            'is_featured' => 'boolean',
        ];
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
