<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index(Request $request)
{
    $query = Quiz::with(['category', 'attempts'])
        ->where('is_active', true)
        ->withCount('questions');

    // Add search functionality if needed
    if ($request->has('search') && $request->search) {
        $query->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
    }

    // Add category filter if needed
    if ($request->has('category') && $request->category) {
        $query->where('category_id', $request->category);
    }

    // Add type filter if needed
    if ($request->has('type') && $request->type) {
        $query->where('type', $request->type);
    }

    $quizzes = $query->paginate(9);
    $categories = Category::where('is_active', true)->get();

    return view('quizzes.index', compact('quizzes', 'categories'));
}

    public function show(Quiz $quiz)
    {
        $quiz->load('questions');
        $userAttempts = QuizAttempt::where('user_id', Auth::id())
            ->where('quiz_id', $quiz->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('quizzes.show', compact('quiz', 'userAttempts'));
    }

    public function start(Quiz $quiz)
    {
        $quiz->load('questions');
        
        return view('quizzes.take', compact('quiz'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $questions = $quiz->questions;
        $score = 0;
        $answers = [];

        foreach ($questions as $question) {
            $userAnswer = $request->input('question_' . $question->id);
            $isCorrect = $userAnswer === $question->correct_answer;
            
            if ($isCorrect) {
                $score += $question->points;
            }

            $answers[] = [
                'question_id' => $question->id,
                'user_answer' => $userAnswer,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect,
                'points' => $isCorrect ? $question->points : 0
            ];
        }

        $attempt = QuizAttempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'score' => $score,
            'total_questions' => $questions->count(),
            'time_taken' => $request->time_taken,
            'answers' => $answers,
            'completed_at' => now(),
        ]);

        return redirect()->route('quizzes.results', $attempt);
    }

    public function results(QuizAttempt $attempt)
    {
        $attempt->load('quiz.questions');
        
        return view('quizzes.results', compact('attempt'));
    }

    public function history()
    {
        $attempts = QuizAttempt::with('quiz')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('quizzes.history', compact('attempts'));
    }
}