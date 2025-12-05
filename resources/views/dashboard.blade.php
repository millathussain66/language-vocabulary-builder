@extends('layouts.app')

@section('title', 'Dashboard - VocabMaster')

@section('content')
<!-- Hero Section -->
<div class="gradient-bg text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold mb-4">Welcome back, {{ Auth::user()->name }}! 👋</h1>
            <p class="text-xl opacity-90 mb-8">Continue your language learning journey today</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('words.practice') }}" class="">
                    <i class="fas fa-play-circle"></i>
                    <span>Start Practice</span>
                </a>
                <a href="{{ route('quizzes.index') }}" class="bg-blue-800 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200 flex items-center space-x-2">
                    <i class="fas fa-tasks"></i>
                    <span>Take a Quiz</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 -mt-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Learned Words Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 card-hover">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Learned Words</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['learned_words'] }}</p>
                        <p class="text-xs text-green-600 mt-1 flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i>
                            <span>+12% this week</span>
                        </p>
                    </div>
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Words Seen Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 card-hover">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Words Seen</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_words_seen'] }}</p>
                        <p class="text-xs text-blue-600 mt-1 flex items-center">
                            <i class="fas fa-eye mr-1"></i>
                            <span>Active learning</span>
                        </p>
                    </div>
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-book-open text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quiz Score Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 card-hover">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Avg Quiz Score</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['average_quiz_score'] }}%</p>
                        <p class="text-xs text-purple-600 mt-1 flex items-center">
                            <i class="fas fa-chart-line mr-1"></i>
                            <span>Great progress!</span>
                        </p>
                    </div>
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-trophy text-purple-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Favorites Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 card-hover">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Favorite Words</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['favorite_words'] }}</p>
                        <p class="text-xs text-yellow-600 mt-1 flex items-center">
                            <i class="fas fa-star mr-1"></i>
                            <span>Personal collection</span>
                        </p>
                    </div>
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-heart text-yellow-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-bolt text-yellow-500 mr-3"></i>
                        Quick Actions
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('words.index') }}" class="group p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl hover:from-blue-100 hover:to-blue-200 transition duration-200 text-center card-hover">
                            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-blue-600 transition duration-200">
                                <i class="fas fa-book text-white text-lg"></i>
                            </div>
                            <span class="font-semibold text-blue-900 group-hover:text-blue-800">Browse Words</span>
                        </a>

                        <a href="{{ route('words.practice') }}" class="group p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl hover:from-green-100 hover:to-green-200 transition duration-200 text-center card-hover">
                            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-green-600 transition duration-200">
                                <i class="fas fa-play text-white text-lg"></i>
                            </div>
                            <span class="font-semibold text-green-900 group-hover:text-green-800">Practice</span>
                        </a>

                        <a href="{{ route('quizzes.index') }}" class="group p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl hover:from-purple-100 hover:to-purple-200 transition duration-200 text-center card-hover">
                            <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-purple-600 transition duration-200">
                                <i class="fas fa-tasks text-white text-lg"></i>
                            </div>
                            <span class="font-semibold text-purple-900 group-hover:text-purple-800">Take Quiz</span>
                        </a>

                        <a href="{{ route('favorites.index') }}" class="group p-4 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl hover:from-yellow-100 hover:to-yellow-200 transition duration-200 text-center card-hover">
                            <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-yellow-600 transition duration-200">
                                <i class="fas fa-star text-white text-lg"></i>
                            </div>
                            <span class="font-semibold text-yellow-900 group-hover:text-yellow-800">Favorites</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Quiz Attempts -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <i class="fas fa-history text-purple-500 mr-3"></i>
                            Recent Quiz Attempts
                        </h3>
                        <a href="{{ route('quizzes.history') }}" class="text-sm text-blue-600 hover:text-blue-500 font-medium">View All</a>
                    </div>
                    
                    @if($recentAttempts->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentAttempts as $attempt)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition duration-200">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-tasks text-white"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $attempt->quiz->title }}</p>
                                            <p class="text-sm text-gray-500">{{ $attempt->completed_at->format('M j, Y g:i A') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-gray-900 text-lg">{{ $attempt->score }}/{{ $attempt->total_questions }}</p>
                                        <div class="flex items-center space-x-2">
                                            <div class="w-16 bg-gray-200 rounded-full h-2">
                                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $attempt->percentage }}%"></div>
                                            </div>
                                            <span class="text-sm font-medium text-gray-700">{{ $attempt->percentage }}%</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-tasks text-gray-400 text-3xl"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">No quiz attempts yet</h4>
                            <p class="text-gray-500 mb-4">Start your learning journey by taking a quiz</p>
                            <a href="{{ route('quizzes.index') }}" class="inline-flex items-center space-x-2 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200">
                                <i class="fas fa-play"></i>
                                <span>Take First Quiz</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-8">
            <!-- Recommended Quizzes -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-fire text-red-500 mr-3"></i>
                        Recommended Quizzes
                    </h3>
                    <div class="space-y-4">
                        @foreach($recommendedQuizzes as $quiz)
                            <a href="{{ route('quizzes.show', $quiz) }}" class="block p-4 border border-gray-200 rounded-xl hover:border-blue-300 hover:bg-blue-50 transition duration-200 card-hover">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900 mb-1">{{ $quiz->title }}</p>
                                        <p class="text-sm text-gray-500 mb-2">{{ $quiz->category->name }}</p>
                                        <div class="flex items-center space-x-3 text-xs">
                                            <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full">
                                                <i class="fas fa-question-circle mr-1"></i>
                                                {{ $quiz->question_count }} questions
                                            </span>
                                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full">
                                                <i class="fas fa-clock mr-1"></i>
                                                {{ $quiz->time_limit }}min
                                            </span>
                                        </div>
                                    </div>
                                    <div class="w-10 h-10 bg-gradient-to-r from-green-400 to-blue-500 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-play text-white text-sm"></i>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Categories -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-folder-open text-indigo-500 mr-3"></i>
                        Word Categories
                    </h3>
                    <div class="space-y-3">
                        @foreach($categories as $category)
                            <a href="{{ route('words.index', ['category' => $category->id]) }}" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-200 group">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center 
                                        {{ $category->difficulty == 'beginner' ? 'bg-green-100 text-green-600' : 
                                           ($category->difficulty == 'intermediate' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600') }}">
                                        <i class="fas fa-folder"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 group-hover:text-blue-600">{{ $category->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $category->word_count }} words</p>
                                    </div>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full font-medium
                                    {{ $category->difficulty == 'beginner' ? 'bg-green-100 text-green-800' : 
                                       ($category->difficulty == 'intermediate' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($category->difficulty) }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Daily Motivation -->
            <div class="bg-gradient-to-r from-purple-500 to-blue-600 rounded-2xl text-white p-6">
                <div class="text-center">
                    <i class="fas fa-quote-left text-2xl opacity-50 mb-4"></i>
                    <p class="text-lg font-semibold mb-4">"The limits of my language are the limits of my world."</p>
                    <p class="text-sm opacity-75">- Ludwig Wittgenstein</p>
                    <div class="mt-4 flex justify-center">
                        <div class="flex space-x-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-yellow-300"></i>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection