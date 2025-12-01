<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reaction_list_id',
        'user_id',
        'parent_id',
        'type',
        'content',
    ];

    /**
     * Relasi: Reaction menggunakan satu ReactionList
     */
    public function reactionList()
    {
        return $this->belongsTo(ReactionList::class);
    }

    /**
     * Relasi: Reaction dibuat oleh satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Parent Schedule
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'parent_id')
            ->where('type', 'schedule');
    }

    /**
     * Relasi: Parent Comment
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'parent_id')
            ->where('type', 'comment');
    }
}
