<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'maker_id',
        'priority_id',
        'color_id',
        'visibility',
        'shareable',
        'title',
        'start',
        'end',
        'status',
        'note',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start' => 'datetime',
            'end' => 'datetime',
            'shareable' => 'boolean',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Relasi: Schedule dibuat oleh satu User (maker)
     */
    public function maker()
    {
        return $this->belongsTo(User::class, 'maker_id');
    }

    /**
     * Relasi: Schedule memiliki satu Priority
     */
    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    /**
     * Relasi: Schedule memiliki satu Color (opsional)
     */
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * Relasi: Schedule terhubung dengan banyak Users (many-to-many)
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_schedule')
            ->withTimestamps();
    }

    /**
     * Relasi: Schedule memiliki banyak Comments
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'parent_id')
            ->where('type', 'schedule');
    }

    /**
     * Relasi: Schedule memiliki banyak Reactions
     */
    public function reactions()
    {
        return $this->hasMany(Reaction::class, 'parent_id')
            ->where('type', 'schedule');
    }
}
