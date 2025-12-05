@extends('layouts.app')

@section('title', $quiz->title . ' - Quiz Details - VocabMaster')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <!-- Gradient Header -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-8 py-6 text-white">
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                <div class="flex-1">
                    <!-- Breadcrumb -->
                    <nav class="flex items-center space-x-2 text-blue-200 text-sm mb-4">
                        <a href="{{ route('quizzes.index') }}" class="hover:text-white transition duration-200 flex items-center space-x-1">
                            <i class="fas fa-arrow-left"></i>
                            <span>Back to Quizzes</span>
                        </a>
                        <span class="text-blue-300">•</span>
                        <span>Quiz Details</span>
                    </nav>

                    <!-- Quiz Title -->
                    <h1 class="text-3xl lg:text-4xl font-bold mb-4">{{ $quiz->title }}</h1>
                    
                    <!-- Quiz Description -->
                    @if($quiz->description)
                    <p class="text-blue-100 text-lg leading-relaxed max-w-3xl">{{ $quiz->description }}</p>
                    @endif
                </div>

                <!-- Start Quiz Button -->
                <div class="lg:w-64">
                    <a href="{{ route('quizzes.start', $quiz) }}" 
                       class="block w-full bg-white text-blue-600 text-center py-4 px-6 rounded-xl font-bold text-lg hover:bg-blue-50 transition duration-200 transform hover:-translate-y-1 shadow-lg">
                        <div class="flex items-center justify-center space-x-2">
                            <i class="fas fa-play-circle"></i>
                            <span>Start Quiz</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Quiz Stats -->
        <div class="p-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900 mb-1">{{ $quiz->questions->count() }}</div>
                    <div class="text-sm text-gray-500">Questions</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900 mb-1">
                        {{ $quiz->time_limit ?? 'Untimed' }}
                    </div>
                    <div class="text-sm text-gray-500">Time Limit</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900 mb-1">
                        {{ $quiz->type == 'multiple_choice' ? 'Multiple Choice' : 'Fill in Blank' }}
                    </div>
                    <div class="text-sm text-gray-500">Quiz Type</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900 mb-1">
                        {{ $userAttempts->count() }}
                    </div>
                    <div class="text-sm text-gray-500">Your Attempts</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Quiz Details -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Quiz Information -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                    Quiz Information
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Difficulty & Category -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <span class="text-gray-700 font-medium">Category:</span>
                            @if($quiz->category)
                            <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                <i class="fas fa-folder mr-2"></i>
                                {{ $quiz->category->name }}
                            </span>
                            @else
                            <span class="text-gray-500">General</span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <span class="text-gray-700 font-medium">Quiz Type:</span>
                            <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">
                                <i class="fas {{ $quiz->type == 'multiple_choice' ? 'fa-list-ul' : 'fa-edit' }} mr-2"></i>
                                {{ $quiz->type == 'multiple_choice' ? 'Multiple Choice' : 'Fill in Blank' }}
                            </span>
                        </div>
                    </div>

                    <!-- Time & Questions -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <span class="text-gray-700 font-medium">Time Limit:</span>
                            @if($quiz->time_limit)
                            <span class="inline-flex items-center px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-sm font-medium">
                                <i class="fas fa-clock mr-2"></i>
                                {{ $quiz->time_limit }} minutes
                            </span>
                            @else
                            <span class="text-gray-500">No time limit</span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <span class="text-gray-700 font-medium">Total Questions:</span>
                            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                <i class="fas fa-question-circle mr-2"></i>
                                {{ $quiz->questions->count() }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quiz Instructions -->
                <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                    <h4 class="font-semibold text-yellow-900 mb-2 flex items-center">
                        <i class="fas fa-lightbulb text-yellow-600 mr-2"></i>
                        Instructions
                    </h4>
                    <ul class="text-yellow-800 space-y-1 text-sm">
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-yellow-600 text-xs"></i>
                            <span>Read each question carefully before answering</span>
                        </li>
                        @if($quiz->time_limit)
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-yellow-600 text-xs"></i>
                            <span>This quiz is timed - manage your time wisely</span>
                        </li>
                        @endif
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-yellow-600 text-xs"></i>
                            <span>You can review your answers before submitting</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-yellow-600 text-xs"></i>
                            <span>Your progress will be saved automatically</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Question Preview -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-eye text-green-500 mr-3"></i>
                    Question Preview
                </h2>

                <div class="space-y-6">
                    @foreach($quiz->questions->take(3) as $index => $question)
                    <div class="border border-gray-200 rounded-xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-semibold text-gray-900">Question {{ $index + 1 }}</h4>
                            <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                {{ $question->points }} point{{ $question->points > 1 ? 's' : '' }}
                            </span>
                        </div>
                        
                        <p class="text-gray-800 mb-4 text-lg">{{ $question->question }}</p>

                        @if($quiz->type == 'multiple_choice')
                        <div class="space-y-2">
                            @foreach(['A', 'B', 'C', 'D'] as $option)
                                @if($question->{'option_' . strtolower($option)})
                                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                    <div class="w-6 h-6 border-2 border-gray-300 rounded-full flex items-center justify-center">
                                        <span class="text-xs font-semibold text-gray-600">{{ $option }}</span>
                                    </div>
                                    <span class="text-gray-700">{{ $question->{'option_' . strtolower($option)} }}</span>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach

                    @if($quiz->questions->count() > 3)
                    <div class="text-center">
                        <p class="text-gray-500">
                            ... and {{ $quiz->questions->count() - 3 }} more questions
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - User Attempts & Actions -->
        <div class="space-y-8">
            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-bolt text-yellow-500 mr-3"></i>
                    Quick Actions
                </h3>

                <div class="space-y-4">
                    <a href="{{ route('quizzes.start', $quiz) }}" 
                       class="block w-full bg-gradient-to-r from-green-500 to-green-600 text-white text-center py-4 px-4 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition duration-200 transform hover:-translate-y-0.5">
                        <div class="flex items-center justify-center space-x-2">
                            <i class="fas fa-play-circle"></i>
                            <span>Start New Attempt</span>
                        </div>
                    </a>

                    @if($userAttempts->count() > 0)
                    <a href="{{ route('quizzes.history') }}" 
                       class="block w-full bg-blue-600 text-white text-center py-4 px-4 rounded-xl font-semibold hover:bg-blue-700 transition duration-200">
                        <div class="flex items-center justify-center space-x-2">
                            <i class="fas fa-history"></i>
                            <span>View All Attempts</span>
                        </div>
                    </a>
                    @endif

                    <a href="{{ route('quizzes.index') }}" 
                       class="block w-full bg-gray-200 text-gray-700 text-center py-4 px-4 rounded-xl font-semibold hover:bg-gray-300 transition duration-200">
                        <div class="flex items-center justify-center space-x-2">
                            <i class="fas fa-arrow-left"></i>
                            <span>Back to Quizzes</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Your Recent Attempts -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-history text-purple-500 mr-3"></i>
                    Your Recent Attempts
                </h3>

                @if($userAttempts->count() > 0)
                    <div class="space-y-4">
                        @foreach($userAttempts->take(3) as $attempt)
                        <div class="p-4 border border-gray-200 rounded-xl hover:border-blue-300 transition duration-200">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-500">
                                    {{ $attempt->completed_at->format('M j, Y') }}
                                </span>
                                <span class="text-sm font-semibold {{ $attempt->percentage >= 70 ? 'text-green-600' : ($attempt->percentage >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $attempt->percentage }}%
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700">
                                    Score: {{ $attempt->score }}/{{ $attempt->total_questions }}
                                </span>
                                @if($attempt->time_taken)
                                <span class="text-xs text-gray-500">
                                    {{ floor($attempt->time_taken / 60) }}:{{ sprintf('%02d', $attempt->time_taken % 60) }}
                                </span>
                                @endif
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                <div class="h-2 rounded-full {{ $attempt->percentage >= 70 ? 'bg-green-500' : ($attempt->percentage >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}" 
                                     style="width: {{ $attempt->percentage }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @if($userAttempts->count() > 3)
                    <div class="text-center mt-4">
                        <a href="{{ route('quizzes.history') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                            View all {{ $userAttempts->count() }} attempts
                        </a>
                    </div>
                    @endif
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-history text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 text-sm">No attempts yet</p>
                        <p class="text-gray-400 text-xs mt-1">Take the quiz to see your results here</p>
                    </div>
                @endif
            </div>

            <!-- Quiz Statistics -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-chart-bar text-blue-500 mr-3"></i>
                    Quiz Statistics
                </h3>

                <div class="space-y-4">
                    @php
                        $bestAttempt = $userAttempts->sortByDesc('percentage')->first();
                        $averageScore = $userAttempts->avg('percentage');
                        $totalTime = $userAttempts->sum('time_taken');
                    @endphp

                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <span class="text-blue-700 text-sm">Best Score</span>
                        <span class="font-bold text-blue-900">
                            {{ $bestAttempt ? $bestAttempt->percentage . '%' : 'N/A' }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                        <span class="text-green-700 text-sm">Average Score</span>
                        <span class="font-bold text-green-900">
                            {{ $averageScore ? round($averageScore, 1) . '%' : 'N/A' }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                        <span class="text-purple-700 text-sm">Total Attempts</span>
                        <span class="font-bold text-purple-900">{{ $userAttempts->count() }}</span>
                    </div>

                    @if($totalTime > 0)
                    <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg">
                        <span class="text-orange-700 text-sm">Total Time Spent</span>
                        <span class="font-bold text-orange-900">
                            {{ floor($totalTime / 60) }}:{{ sprintf('%02d', $totalTime % 60) }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Difficulty Assessment -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-tachometer-alt text-red-500 mr-3"></i>
                    Difficulty Level
                </h3>
                
                <div class="text-center">
                    @php
                        $avgScore = $userAttempts->avg('percentage');
                        if ($avgScore >= 80) {
                            $difficulty = 'Easy';
                            $color = 'green';
                        } elseif ($avgScore >= 60) {
                            $difficulty = 'Medium';
                            $color = 'yellow';
                        } else {
                            $difficulty = 'Challenging';
                            $color = 'red';
                        }
                    @endphp
                    
                    <div class="w-20 h-20 mx-auto mb-4 bg-{{ $color }}-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl font-bold text-{{ $color }}-600">{{ $userAttempts->count() > 0 ? round($avgScore) : '?' }}%</span>
                    </div>
                    <p class="text-{{ $color }}-600 font-semibold">{{ $difficulty }}</p>
                    <p class="text-gray-500 text-sm mt-1">Based on your performance</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom CTA -->
    <div class="mt-12 text-center">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl text-white p-8">
            <h2 class="text-2xl font-bold mb-4">Ready to Test Your Knowledge?</h2>
            <p class="text-blue-100 text-lg mb-6 max-w-2xl mx-auto">
                Take this quiz now and see how much you've learned. Challenge yourself and track your progress!
            </p>
            <a href="{{ route('quizzes.start', $quiz) }}" 
               class="inline-flex items-center space-x-3 bg-white text-blue-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-blue-50 transition duration-200 transform hover:-translate-y-1 shadow-lg">
                <i class="fas fa-play-circle"></i>
                <span>Start Quiz Now</span>
            </a>
        </div>
    </div>
</div>

<style>
.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 5px 10px -5px rgba(0, 0, 0, 0.04);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add animation to stats cards
    const statsCards = document.querySelectorAll('.bg-gray-50, .bg-blue-50, .bg-green-50, .bg-purple-50, .bg-orange-50');
    
    statsCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.transition = 'all 0.2s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Add click animation to buttons
    const buttons = document.querySelectorAll('a[href*="start"]');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Add a small delay to show the animation
            setTimeout(() => {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            }, 10);
        });
    });

    // Progress bar animation
    const progressBars = document.querySelectorAll('.h-2.rounded-full');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0';
        setTimeout(() => {
            bar.style.transition = 'width 1s ease-in-out';
            bar.style.width = width;
        }, 100);
    });
});
</script>
@endsection