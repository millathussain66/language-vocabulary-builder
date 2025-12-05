<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean'
        ];
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function userProgress()
    {
        return $this->hasMany(UserProgress::class);
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function favoriteWords()
    {
        return $this->belongsToMany(Word::class, 'favorites');
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function getLearnedWordsCountAttribute()
    {
        return $this->userProgress()->where('mastered', true)->count();
    }

    public function getTotalWordsSeenAttribute()
    {
        return $this->userProgress()->count();
    }

    public function getAverageQuizScoreAttribute()
    {
        $attempts = $this->quizAttempts();
        if ($attempts->count() === 0) return 0;
        
        return round($attempts->avg('score'), 2);
    }
}