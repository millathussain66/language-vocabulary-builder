<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'word_id',
        'times_seen',
        'times_correct',
        'times_incorrect',
        'mastered',
        'last_reviewed_at'
    ];

    protected $casts = [
        'last_reviewed_at' => 'datetime',
        'mastered' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function word()
    {
        return $this->belongsTo(Word::class);
    }

    public function getAccuracyAttribute()
    {
        $total = $this->times_correct + $this->times_incorrect;
        return $total > 0 ? round(($this->times_correct / $total) * 100, 2) : 0;
    }
}