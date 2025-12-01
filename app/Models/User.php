<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi: User membuat banyak Schedules (sebagai maker)
     */
    public function createdSchedules()
    {
        return $this->hasMany(Schedule::class, 'maker_id');
    }

    /**
     * Relasi: User terhubung dengan banyak Schedules (many-to-many)
     */
    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'user_schedule')
            ->withTimestamps();
    }

    /**
     * Relasi: User membuat banyak Comments
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Relasi: User memberikan banyak Reactions
     */
    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }
}
