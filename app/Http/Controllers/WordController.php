<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Word;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WordController extends Controller
{
    public function index(Request $request)
    {
        $query = Word::with('category')
            ->where('is_active', true);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('word', 'like', '%' . $request->search . '%')
                  ->orWhere('meaning', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filter by difficulty
        if ($request->has('difficulty') && $request->difficulty) {
            $query->where('difficulty', $request->difficulty);
        }

        $words = $query->paginate(20);
        $categories = Category::where('is_active', true)->get();

        return view('words.index', compact('words', 'categories'));
    }

    public function show(Word $word)
    {
        $user = Auth::user();
        $userProgress = null;

        if ($user) {
            $userProgress = $word->getUserProgress($user);
            
            // Mark as seen
            if ($userProgress) {
                $userProgress->increment('times_seen');
                $userProgress->update(['last_reviewed_at' => now()]);
            } else {
                UserProgress::create([
                    'user_id' => $user->id,
                    'word_id' => $word->id,
                    'times_seen' => 1,
                    'last_reviewed_at' => now(),
                ]);
            }
        }

        $relatedWords = Word::where('category_id', $word->category_id)
            ->where('id', '!=', $word->id)
            ->where('is_active', true)
            ->limit(5)
            ->get();

        return view('words.show', compact('word', 'userProgress', 'relatedWords'));
    }

    public function practice(Request $request)
    {
        $user = Auth::user();
        $query = Word::with('category')->where('is_active', true);

        // Get words that need practice
        if ($user && $request->has('practice_type')) {
            switch ($request->practice_type) {
                case 'new':
                    $learnedWordIds = $user->userProgress()->pluck('word_id');
                    $query->whereNotIn('id', $learnedWordIds);
                    break;
                case 'needs_review':
                    $query->whereHas('userProgress', function ($q) use ($user) {
                        $q->where('user_id', $user->id)
                          ->where('mastered', false)
                          ->where('times_correct', '<', 3);
                    });
                    break;
                case 'mastered':
                    $query->whereHas('userProgress', function ($q) use ($user) {
                        $q->where('user_id', $user->id)
                          ->where('mastered', true);
                    });
                    break;
            }
        }

        $words = $query->paginate(15);

        return view('words.practice', compact('words'));
    }
}