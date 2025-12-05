<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'difficulty',
        'description',
        'is_active'
    ];

    public function words()
    {
        return $this->hasMany(Word::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function getWordCountAttribute()
    {
        return $this->words()->count();
    }
}