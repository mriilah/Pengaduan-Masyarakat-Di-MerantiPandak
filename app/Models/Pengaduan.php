<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengaduan extends Model
{
    use HasFactory;

    const STATUS_DIAJUKAN = 'diajukan';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_SELESAI = 'selesai';

    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul',
        'deskripsi',
        'foto',
        'status',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
                self::STATUS_DIAJUKAN => 'bg-yellow-100 text-yellow-800',
                self::STATUS_DIPROSES => 'bg-blue-100 text-blue-800',
                self::STATUS_SELESAI => 'bg-green-100 text-green-800',
                default => 'bg-gray-100 text-gray-800',
            };
    }

    public function getStatusLabelAttribute(): string
    {
        return ucfirst($this->status);
    }
}
