<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'parent_id',
        'type',
        'content',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Relasi: Comment ditulis oleh satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi Polymorphic: Parent bisa Schedule atau Comment lain
     * Untuk mengambil parent Schedule
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'parent_id')
            ->where('type', 'schedule');
    }

    /**
     * Relasi: Parent Comment (untuk reply)
     */
    public function parentComment()
    {
        return $this->belongsTo(Comment::class, 'parent_id')
            ->where('type', 'comment');
    }

    /**
     * Relasi: Comment memiliki banyak replies (child comments)
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')
            ->where('type', 'comment');
    }

    /**
     * Relasi: Comment memiliki banyak Reactions
     */
    public function reactions()
    {
        return $this->hasMany(Reaction::class, 'parent_id')
            ->where('type', 'comment');
    }
}
