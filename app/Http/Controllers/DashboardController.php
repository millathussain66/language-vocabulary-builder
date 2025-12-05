<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\UserProgress;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $stats = [
            'learned_words' => $user->learned_words_count,
            'total_words_seen' => $user->total_words_seen,
            'average_quiz_score' => $user->average_quiz_score,
            'favorite_words' => $user->favorites()->count(),
        ];

        $recentAttempts = QuizAttempt::with('quiz')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $categories = Category::withCount('words')
            ->where('is_active', true)
            ->get();

        $recommendedQuizzes = Quiz::with('category')
            ->where('is_active', true)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('dashboard', compact('stats', 'recentAttempts', 'categories', 'recommendedQuizzes'));
    }
}