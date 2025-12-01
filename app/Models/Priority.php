<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'color_id',
        'name',
        'note',
    ];

    /**
     * Relasi: Priority memiliki satu Color
     */
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * Relasi: Priority digunakan oleh banyak Schedules
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
