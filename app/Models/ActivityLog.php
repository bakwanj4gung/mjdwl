<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    /**
     * Nonaktifkan updated_at karena hanya ada created_at
     */
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'properties' => 'array',
            'created_at' => 'datetime',
        ];
    }

    /**
     * Relasi Polymorphic: Subject (target yang diubah)
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * Relasi Polymorphic: Causer (pelaku yang melakukan aksi)
     */
    public function causer()
    {
        return $this->morphTo();
    }
}
