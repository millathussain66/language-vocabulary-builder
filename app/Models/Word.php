<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'word',
        'meaning',
        'pronunciation',
        'example_sentence',
        'audio_path',
        'difficulty',
        'language',
        'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function userProgress()
    {
        return $this->hasMany(UserProgress::class);
    }

    public function isFavoritedBy(User $user)
    {
        return $this->favorites()->where('user_id', $user->id)->exists();
    }

    public function getUserProgress(User $user)
    {
        return $this->userProgress()->where('user_id', $user->id)->first();
    }
}