@extends('layouts.app')

@section('title', 'Practice Words - VocabMaster')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="text-center mb-12">
        <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-brain text-white text-3xl"></i>
        </div>
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Practice Vocabulary</h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            Strengthen your vocabulary through interactive practice sessions. Review words you've learned and discover new ones.
        </p>
        <div class="mt-6 flex flex-wrap justify-center gap-4">
            <div class="flex items-center space-x-2 bg-green-50 px-4 py-2 rounded-full">
                <i class="fas fa-sync-alt text-green-600"></i>
                <span class="text-sm font-medium text-green-900">Spaced Repetition</span>
            </div>
            <div class="flex items-center space-x-2 bg-blue-50 px-4 py-2 rounded-full">
                <i class="fas fa-chart-line text-blue-600"></i>
                <span class="text-sm font-medium text-blue-900">Progress Tracking</span>
            </div>
            <div class="flex items-center space-x-2 bg-purple-50 px-4 py-2 rounded-full">
                <i class="fas fa-bullseye text-purple-600"></i>
                <span class="text-sm font-medium text-purple-900">Smart Review</span>
            </div>
        </div>
    </div>

    <!-- Practice Mode Selector -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <i class="fas fa-cogs text-blue-500 mr-3"></i>
            Choose Practice Mode
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('words.practice', ['practice_type' => 'new']) }}" 
               class="practice-mode-card bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-2xl p-6 text-center card-hover group {{ request('practice_type') == 'new' ? 'border-blue-500 ring-2 ring-blue-200' : '' }}">
                <div class="w-16 h-16 bg-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-600 transition duration-200">
                    <i class="fas fa-plus-circle text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">New Words</h3>
                <p class="text-gray-600 text-sm mb-4">Practice words you haven't learned yet</p>
                <div class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                    {{ \App\Models\Word::whereNotIn('id', Auth::user()->userProgress()->pluck('word_id'))->count() }} available
                </div>
            </a>

            <a href="{{ route('words.practice', ['practice_type' => 'needs_review']) }}" 
               class="practice-mode-card bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-200 rounded-2xl p-6 text-center card-hover group {{ request('practice_type') == 'needs_review' ? 'border-yellow-500 ring-2 ring-yellow-200' : '' }}">
                <div class="w-16 h-16 bg-yellow-500 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-yellow-600 transition duration-200">
                    <i class="fas fa-sync-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Needs Review</h3>
                <p class="text-gray-600 text-sm mb-4">Words that need more practice</p>
                <div class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                    {{ \App\Models\UserProgress::where('user_id', Auth::id())->where('mastered', false)->where('times_correct', '<', 3)->count() }} to review
                </div>
            </a>

            <a href="{{ route('words.practice', ['practice_type' => 'mastered']) }}" 
               class="practice-mode-card bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-2xl p-6 text-center card-hover group {{ request('practice_type') == 'mastered' ? 'border-green-500 ring-2 ring-green-200' : '' }}">
                <div class="w-16 h-16 bg-green-500 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-green-600 transition duration-200">
                    <i class="fas fa-check-circle text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Mastered Words</h3>
                <p class="text-gray-600 text-sm mb-4">Review words you've already mastered</p>
                <div class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                    {{ \App\Models\UserProgress::where('user_id', Auth::id())->where('mastered', true)->count() }} mastered
                </div>
            </a>
        </div>
    </div>

    <!-- Practice Session -->
    @if(request('practice_type'))
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    @switch(request('practice_type'))
                        @case('new')
                            <span class="text-blue-600">New Words Practice</span>
                            @break
                        @case('needs_review')
                            <span class="text-yellow-600">Review Needed Words</span>
                            @break
                        @case('mastered')
                            <span class="text-green-600">Mastered Words Review</span>
                            @break
                        @default
                            <span>Vocabulary Practice</span>
                    @endswitch
                </h2>
                <p class="text-gray-600">
                    @switch(request('practice_type'))
                        @case('new')
                            Discover and learn new vocabulary words
                            @break
                        @case('needs_review')
                            Strengthen words that need more practice
                            @break
                        @case('mastered')
                            Maintain your mastery of learned words
                            @break
                    @endswitch
                </p>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-900">{{ $words->count() }}</div>
                    <div class="text-sm text-gray-500">Words to practice</div>
                </div>
                <button id="start-practice" class="bg-green-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-green-700 transition duration-200 flex items-center space-x-2">
                    <i class="fas fa-play-circle"></i>
                    <span>Start Practice</span>
                </button>
            </div>
        </div>

        @if($words->count() > 0)
        <!-- Words Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            @foreach($words as $word)
            <div class="bg-gray-50 rounded-xl p-4 border-2 border-transparent practice-word-card hover:border-blue-300 transition duration-200"
                 data-word-id="{{ $word->id }}"
                 data-word="{{ $word->word }}"
                 data-meaning="{{ $word->meaning }}"
                 data-pronunciation="{{ $word->pronunciation }}"
                 data-example="{{ $word->example_sentence }}"
                 data-difficulty="{{ $word->difficulty }}">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="font-bold text-gray-900 text-lg">{{ $word->word }}</h3>
                    <span class="px-2 py-1 text-xs font-medium rounded-full 
                        {{ $word->difficulty == 'beginner' ? 'bg-green-100 text-green-800' : 
                           ($word->difficulty == 'intermediate' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($word->difficulty) }}
                    </span>
                </div>
                
                @if($word->pronunciation)
                <div class="flex items-center space-x-1 text-gray-600 text-sm mb-2">
                    <i class="fas fa-volume-up"></i>
                    <span>{{ $word->pronunciation }}</span>
                </div>
                @endif
                
                <p class="text-gray-700 text-sm line-clamp-2">{{ $word->meaning }}</p>
                
                <div class="flex items-center justify-between mt-3">
                    <span class="text-xs text-gray-500">{{ $word->category->name }}</span>
                    @if($word->userProgress)
                        @php $progress = $word->userProgress->first(); @endphp
                        <div class="text-xs text-gray-500">
                            {{ $progress->accuracy ?? 0 }}% accuracy
                        </div>
                    @else
                        <span class="text-xs text-blue-500">New word</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($words->hasPages())
        <div class="border-t border-gray-200 pt-6">
            {{ $words->links() }}
        </div>
        @endif

        @else
        <!-- Empty State for Practice Mode -->
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check-circle text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3">
                @switch(request('practice_type'))
                    @case('new')
                        No New Words Available
                        @break
                    @case('needs_review')
                        All Words Mastered!
                        @break
                    @case('mastered')
                        No Mastered Words Yet
                        @break
                @endswitch
            </h3>
            <p class="text-gray-600 mb-6 max-w-md mx-auto">
                @switch(request('practice_type'))
                    @case('new')
                        You've practiced all available new words! Check back later or explore other categories.
                        @break
                    @case('needs_review')
                        Great job! All your words are currently mastered. Keep up the good work!
                        @break
                    @case('mastered')
                        You haven't mastered any words yet. Start practicing to build your vocabulary!
                        @break
                @endswitch
            </p>
            <a href="{{ route('words.index') }}" 
               class="inline-flex items-center space-x-2 bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition duration-200 font-semibold">
                <i class="fas fa-book-open"></i>
                <span>Browse More Words</span>
            </a>
        </div>
        @endif
    </div>
    @endif

    <!-- Practice Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Words Practiced</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ Auth::user()->userProgress()->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-book text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Mastered Words</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ Auth::user()->userProgress()->where('mastered', true)->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Need Practice</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ Auth::user()->userProgress()->where('mastered', false)->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-sync-alt text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Average Accuracy</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        @php
                            $progress = Auth::user()->userProgress;
                            $totalAccuracy = $progress->avg('accuracy') ?? 0;
                        @endphp
                        {{ round($totalAccuracy) }}%
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Practice Modal -->
    <div id="practice-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
            <div class="p-6">
                <!-- Progress Header -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Practice Session</h3>
                        <p class="text-gray-600" id="practice-mode-display">
                            @switch(request('practice_type'))
                                @case('new') New Words @break
                                @case('needs_review') Review Needed @break
                                @case('mastered') Mastered Words @break
                            @endswitch
                        </p>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-gray-900">
                            <span id="current-word-number">1</span>/<span id="total-words">{{ $words->count() }}</span>
                        </div>
                        <div class="text-sm text-gray-500">Progress</div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="w-full bg-gray-200 rounded-full h-2 mb-6">
                    <div id="practice-progress" class="bg-green-500 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>

                <!-- Practice Content -->
                <div id="practice-content" class="space-y-6">
                    <!-- Content will be loaded dynamically -->
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-3 mt-8">
                    <button id="show-answer" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition duration-200">
                        Show Answer
                    </button>
                    <button id="next-word" class="flex-1 bg-green-600 text-white py-3 rounded-xl font-semibold hover:bg-green-700 transition duration-200 hidden">
                        Next Word
                    </button>
                    <button id="finish-practice" class="flex-1 bg-gray-600 text-white py-3 rounded-xl font-semibold hover:bg-gray-700 transition duration-200 hidden">
                        Finish Practice
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.practice-word-card {
    cursor: pointer;
    transition: all 0.2s ease;
}

.practice-word-card:hover {
    transform: translateY(-2px);
}

.practice-mode-card {
    transition: all 0.3s ease;
}

.practice-mode-card:hover {
    transform: translateY(-3px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const practiceModal = document.getElementById('practice-modal');
    const practiceContent = document.getElementById('practice-content');
    const startPracticeBtn = document.getElementById('start-practice');
    const showAnswerBtn = document.getElementById('show-answer');
    const nextWordBtn = document.getElementById('next-word');
    const finishPracticeBtn = document.getElementById('finish-practice');
    const currentWordNumber = document.getElementById('current-word-number');
    const totalWords = document.getElementById('total-words');
    const practiceProgress = document.getElementById('practice-progress');
    
    let practiceWords = [];
    let currentWordIndex = 0;
    let sessionResults = [];

    // Initialize practice words from the grid
    function initializePracticeWords() {
        practiceWords = Array.from(document.querySelectorAll('.practice-word-card')).map(card => ({
            id: card.dataset.wordId,
            word: card.dataset.word,
            meaning: card.dataset.meaning,
            pronunciation: card.dataset.pronunciation,
            example: card.dataset.example,
            difficulty: card.dataset.difficulty,
            element: card
        }));
    }

    // Start practice session
    if (startPracticeBtn) {
        startPracticeBtn.addEventListener('click', function() {
            initializePracticeWords();
            if (practiceWords.length > 0) {
                currentWordIndex = 0;
                sessionResults = [];
                startPracticeSession();
            }
        });
    }

    // Individual word card click
    document.querySelectorAll('.practice-word-card').forEach(card => {
        card.addEventListener('click', function() {
            practiceWords = [{
                id: this.dataset.wordId,
                word: this.dataset.word,
                meaning: this.dataset.meaning,
                pronunciation: this.dataset.pronunciation,
                example: this.dataset.example,
                difficulty: this.dataset.difficulty,
                element: this
            }];
            currentWordIndex = 0;
            sessionResults = [];
            startPracticeSession();
        });
    });

    // Show answer
    showAnswerBtn.addEventListener('click', function() {
        const currentWord = practiceWords[currentWordIndex];
        practiceContent.innerHTML = `
            <div class="text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-lightbulb text-green-600 text-3xl"></i>
                </div>
                <h4 class="text-3xl font-bold text-gray-900 mb-4">${currentWord.word}</h4>
                ${currentWord.pronunciation ? `
                    <div class="flex items-center justify-center space-x-2 text-gray-600 mb-4">
                        <i class="fas fa-volume-up"></i>
                        <span class="text-lg">${currentWord.pronunciation}</span>
                    </div>
                ` : ''}
                <div class="bg-gray-100 rounded-xl p-6 mb-4">
                    <p class="text-xl text-gray-800 font-medium">${currentWord.meaning}</p>
                </div>
                ${currentWord.example ? `
                    <div class="bg-blue-50 rounded-xl p-4">
                        <p class="text-gray-700 italic">"${currentWord.example}"</p>
                    </div>
                ` : ''}
            </div>
        `;
        
        showAnswerBtn.classList.add('hidden');
        if (currentWordIndex < practiceWords.length - 1) {
            nextWordBtn.classList.remove('hidden');
        } else {
            finishPracticeBtn.classList.remove('hidden');
        }

        // Mark as correct for this session
        sessionResults.push({
            wordId: currentWord.id,
            correct: true,
            timestamp: new Date()
        });
    });

    // Next word
    nextWordBtn.addEventListener('click', function() {
        currentWordIndex++;
        loadPracticeWord();
    });

    // Finish practice
    finishPracticeBtn.addEventListener('click', function() {
        practiceModal.classList.add('hidden');
        showSessionSummary();
    });

    function startPracticeSession() {
        practiceModal.classList.remove('hidden');
        loadPracticeWord();
        updateProgress();
    }

    function loadPracticeWord() {
        const currentWord = practiceWords[currentWordIndex];
        
        practiceContent.innerHTML = `
            <div class="text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-brain text-blue-600 text-3xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-900 mb-4">What does this word mean?</h4>
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl p-8 mb-6">
                    <p class="text-4xl font-bold text-white">${currentWord.word}</p>
                </div>
                <p class="text-gray-500">Think about the meaning, then click "Show Answer" to check</p>
            </div>
        `;

        showAnswerBtn.classList.remove('hidden');
        nextWordBtn.classList.add('hidden');
        finishPracticeBtn.classList.add('hidden');
        
        currentWordNumber.textContent = currentWordIndex + 1;
        updateProgress();
    }

    function updateProgress() {
        const progress = ((currentWordIndex + 1) / practiceWords.length) * 100;
        practiceProgress.style.width = `${progress}%`;
    }

    function showSessionSummary() {
        const correctAnswers = sessionResults.filter(result => result.correct).length;
        const accuracy = Math.round((correctAnswers / sessionResults.length) * 100);
        
        const summaryHTML = `
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
                <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-trophy text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Practice Complete!</h3>
                        <p class="text-gray-600 mb-6">Great job on your practice session.</p>
                        
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-blue-50 rounded-xl p-4">
                                <div class="text-2xl font-bold text-blue-600">${sessionResults.length}</div>
                                <div class="text-sm text-blue-700">Words Practiced</div>
                            </div>
                            <div class="bg-green-50 rounded-xl p-4">
                                <div class="text-2xl font-bold text-green-600">${accuracy}%</div>
                                <div class="text-sm text-green-700">Accuracy</div>
                            </div>
                        </div>
                        
                        <div class="flex space-x-3">
                            <button onclick="this.closest('.fixed').remove()" class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-300 transition duration-200">
                                Close
                            </button>
                            <button onclick="location.reload()" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition duration-200">
                                Practice More
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', summaryHTML);
    }

    // Close modal when clicking outside
    practiceModal.addEventListener('click', function(e) {
        if (e.target === practiceModal) {
            practiceModal.classList.add('hidden');
        }
    });
});
</script>
@endsection