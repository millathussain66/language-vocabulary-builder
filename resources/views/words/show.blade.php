@extends('layouts.app')

@section('title', $word->word . ' - Word Details - VocabMaster')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('words.index') }}" class="hover:text-blue-600 transition duration-200 flex items-center space-x-1">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Words</span>
        </a>
        <span class="text-gray-300">•</span>
        <span>Word Details</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Word Header Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Gradient Header -->
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-8 py-6 text-white">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h1 class="text-4xl font-bold mb-2">{{ $word->word }}</h1>
                            @if($word->pronunciation)
                            <div class="flex items-center space-x-3 text-blue-100">
                                <i class="fas fa-volume-up"></i>
                                <span class="text-lg font-medium">{{ $word->pronunciation }}</span>
                                <button class="p-2 bg-blue-400 rounded-full hover:bg-blue-300 transition duration-200">
                                    <i class="fas fa-play text-sm"></i>
                                </button>
                            </div>
                            @endif
                        </div>
                        <div class="flex space-x-2">
                            <!-- Favorite Button -->
                            <form action="{{ route('favorites.toggle', $word) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-3 bg-white bg-opacity-20 rounded-xl hover:bg-opacity-30 transition duration-200">
                                    <i class="fas fa-star {{ $word->isFavoritedBy(Auth::user()) ? 'text-yellow-400' : 'text-white' }} text-xl"></i>
                                </button>
                            </form>
                            <!-- Practice Button -->
                            <button class="p-3 bg-white bg-opacity-20 rounded-xl hover:bg-opacity-30 transition duration-200 practice-word-btn"
                                    data-word="{{ $word->word }}"
                                    data-meaning="{{ $word->meaning }}"
                                    data-pronunciation="{{ $word->pronunciation }}"
                                    data-example="{{ $word->example_sentence }}">
                                <i class="fas fa-brain text-white text-xl"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Word Details -->
                <div class="p-8">
                    <!-- Badges -->
                    <div class="flex flex-wrap gap-3 mb-6">
                        <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                            <i class="fas fa-folder mr-2"></i>
                            {{ $word->category->name }}
                        </span>
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold 
                            {{ $word->difficulty == 'beginner' ? 'bg-green-100 text-green-800' : 
                               ($word->difficulty == 'intermediate' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            <i class="fas fa-signal mr-2"></i>
                            {{ ucfirst($word->difficulty) }} Level
                        </span>
                        <span class="inline-flex items-center px-4 py-2 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold">
                            <i class="fas fa-globe mr-2"></i>
                            {{ ucfirst($word->language) }}
                        </span>
                    </div>

                    <!-- Meaning Section -->
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-book-open text-blue-500 mr-3"></i>
                            Meaning
                        </h3>
                        <div class="bg-blue-50 rounded-2xl p-6">
                            <p class="text-gray-800 text-lg leading-relaxed">{{ $word->meaning }}</p>
                        </div>
                    </div>

                    <!-- Example Sentence -->
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-comment-dots text-green-500 mr-3"></i>
                            Example Sentence
                        </h3>
                        <div class="bg-green-50 rounded-2xl p-6">
                            <p class="text-gray-800 text-lg leading-relaxed italic">"{{ $word->example_sentence }}"</p>
                        </div>
                    </div>

                    <!-- Usage Tips -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6">
                        <h4 class="font-semibold text-yellow-900 mb-3 flex items-center">
                            <i class="fas fa-lightbulb text-yellow-600 mr-2"></i>
                            Usage Tips
                        </h4>
                        <ul class="text-yellow-800 space-y-2 text-sm">
                            <li class="flex items-center space-x-2">
                                <i class="fas fa-check text-yellow-600 text-xs"></i>
                                <span>Try using this word in your daily conversations</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <i class="fas fa-check text-yellow-600 text-xs"></i>
                                <span>Pay attention to the context in the example sentence</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <i class="fas fa-check text-yellow-600 text-xs"></i>
                                <span>Practice the pronunciation to sound more natural</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Related Words -->
            @if($relatedWords->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-random text-purple-500 mr-3"></i>
                    Related Words
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($relatedWords as $relatedWord)
                    <a href="{{ route('words.show', $relatedWord) }}" 
                       class="group p-4 border border-gray-200 rounded-xl hover:border-purple-300 hover:bg-purple-50 transition duration-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-gray-900 group-hover:text-purple-600 transition duration-200">
                                    {{ $relatedWord->word }}
                                </h4>
                                <p class="text-sm text-gray-600 line-clamp-1">{{ $relatedWord->meaning }}</p>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400 group-hover:text-purple-500 transition duration-200"></i>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            <!-- Progress Stats -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-chart-line text-green-500 mr-3"></i>
                    Your Progress
                </h3>

                @if($userProgress)
                <div class="space-y-6">
                    <!-- Accuracy -->
                    <div>
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Mastery Level</span>
                            <span class="font-semibold">{{ $userProgress->accuracy }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="h-3 rounded-full 
                                {{ $userProgress->accuracy >= 80 ? 'bg-green-500' : 
                                   ($userProgress->accuracy >= 60 ? 'bg-yellow-500' : 'bg-red-500') }}" 
                                 style="width: {{ $userProgress->accuracy }}%"></div>
                        </div>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-3 bg-blue-50 rounded-xl">
                            <div class="text-2xl font-bold text-blue-600">{{ $userProgress->times_seen }}</div>
                            <div class="text-xs text-blue-700">Times Seen</div>
                        </div>
                        <div class="text-center p-3 bg-green-50 rounded-xl">
                            <div class="text-2xl font-bold text-green-600">{{ $userProgress->times_correct }}</div>
                            <div class="text-xs text-green-700">Correct</div>
                        </div>
                        <div class="text-center p-3 bg-yellow-50 rounded-xl">
                            <div class="text-2xl font-bold text-yellow-600">{{ $userProgress->times_incorrect }}</div>
                            <div class="text-xs text-yellow-700">Incorrect</div>
                        </div>
                        <div class="text-center p-3 bg-purple-50 rounded-xl">
                            <div class="text-2xl font-bold text-purple-600">
                                {{ $userProgress->mastered ? 'Yes' : 'No' }}
                            </div>
                            <div class="text-xs text-purple-700">Mastered</div>
                        </div>
                    </div>

                    <!-- Last Reviewed -->
                    @if($userProgress->last_reviewed_at)
                    <div class="text-center text-sm text-gray-500">
                        Last reviewed {{ $userProgress->last_reviewed_at->diffForHumans() }}
                    </div>
                    @endif
                </div>
                @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-eye text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500 text-sm">You haven't studied this word yet</p>
                    <p class="text-gray-400 text-xs mt-1">Start practicing to track your progress</p>
                </div>
                @endif

                <!-- Practice Button -->
                <button class="w-full mt-6 bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition duration-200 practice-word-btn"
                        data-word="{{ $word->word }}"
                        data-meaning="{{ $word->meaning }}"
                        data-pronunciation="{{ $word->pronunciation }}"
                        data-example="{{ $word->example_sentence }}">
                    <i class="fas fa-play-circle mr-2"></i>
                    Practice This Word
                </button>
            </div>

            <!-- Word Information -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                    Word Information
                </h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-700 font-medium">Category:</span>
                        <span class="text-gray-900 font-semibold">{{ $word->category->name }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-700 font-medium">Difficulty:</span>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold 
                            {{ $word->difficulty == 'beginner' ? 'bg-green-100 text-green-800' : 
                               ($word->difficulty == 'intermediate' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($word->difficulty) }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-700 font-medium">Language:</span>
                        <span class="text-gray-900 font-semibold">{{ ucfirst($word->language) }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-700 font-medium">Added:</span>
                        <span class="text-gray-900 font-semibold">{{ $word->created_at->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-bolt text-yellow-500 mr-3"></i>
                    Quick Actions
                </h3>
                
                <div class="space-y-3">
                    <a href="{{ route('words.index', ['category' => $word->category_id]) }}" 
                       class="flex items-center justify-between p-3 bg-blue-50 rounded-xl hover:bg-blue-100 transition duration-200 group">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-folder text-white"></i>
                            </div>
                            <span class="font-semibold text-blue-900">Browse Category</span>
                        </div>
                        <i class="fas fa-arrow-right text-blue-400 group-hover:text-blue-600"></i>
                    </a>
                    
                    <a href="{{ route('words.practice', ['practice_type' => 'new']) }}" 
                       class="flex items-center justify-between p-3 bg-green-50 rounded-xl hover:bg-green-100 transition duration-200 group">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-play text-white"></i>
                            </div>
                            <span class="font-semibold text-green-900">Practice More</span>
                        </div>
                        <i class="fas fa-arrow-right text-green-400 group-hover:text-green-600"></i>
                    </a>
                    
                    <a href="{{ route('quizzes.index') }}" 
                       class="flex items-center justify-between p-3 bg-purple-50 rounded-xl hover:bg-purple-100 transition duration-200 group">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-tasks text-white"></i>
                            </div>
                            <span class="font-semibold text-purple-900">Take a Quiz</span>
                        </div>
                        <i class="fas fa-arrow-right text-purple-400 group-hover:text-purple-600"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Practice Modal -->
<div id="practice-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full max-h-[90vh] overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Practice Word</h3>
                <button id="close-modal" class="text-gray-400 hover:text-gray-600 transition duration-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div id="practice-content" class="space-y-6">
                <!-- Content will be loaded here -->
            </div>
            
            <div class="flex space-x-3 mt-6">
                <button id="show-answer" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition duration-200">
                    Show Answer
                </button>
                <button id="next-word" class="flex-1 bg-green-600 text-white py-3 rounded-xl font-semibold hover:bg-green-700 transition duration-200 hidden">
                    Practice Another
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

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
    const practiceModal = document.getElementById('practice-modal');
    const practiceContent = document.getElementById('practice-content');
    const closeModal = document.getElementById('close-modal');
    const showAnswerBtn = document.getElementById('show-answer');
    const nextWordBtn = document.getElementById('next-word');
    const practiceButtons = document.querySelectorAll('.practice-word-btn');

    // Practice word functionality
    practiceButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const word = this.dataset.word;
            const meaning = this.dataset.meaning;
            const pronunciation = this.dataset.pronunciation;
            const example = this.dataset.example;
            
            startPracticeSession(word, meaning, pronunciation, example);
        });
    });

    // Close modal
    closeModal.addEventListener('click', function() {
        practiceModal.classList.add('hidden');
    });

    // Show answer
    showAnswerBtn.addEventListener('click', function() {
        const currentWord = JSON.parse(sessionStorage.getItem('currentPracticeWord'));
        practiceContent.innerHTML = `
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-lightbulb text-green-600 text-2xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-900 mb-2">${currentWord.word}</h4>
                ${currentWord.pronunciation ? `
                    <div class="flex items-center justify-center space-x-2 text-gray-600 mb-3">
                        <i class="fas fa-volume-up"></i>
                        <span class="text-lg">${currentWord.pronunciation}</span>
                    </div>
                ` : ''}
                <div class="bg-gray-100 rounded-xl p-4 mb-3">
                    <p class="text-lg text-gray-800 font-medium">${currentWord.meaning}</p>
                </div>
                ${currentWord.example ? `
                    <div class="bg-blue-50 rounded-xl p-3">
                        <p class="text-gray-700 italic text-sm">"${currentWord.example}"</p>
                    </div>
                ` : ''}
            </div>
        `;
        
        showAnswerBtn.classList.add('hidden');
        nextWordBtn.classList.remove('hidden');

        // Update progress in the backend (simulated)
        updateWordProgress(currentWord.word);
    });

    // Next word
    nextWordBtn.addEventListener('click', function() {
        practiceModal.classList.add('hidden');
        // In a real implementation, this would load another word
        setTimeout(() => {
            showNotification('Great job! Keep practicing to master this word.', 'success');
        }, 300);
    });

    function startPracticeSession(word, meaning, pronunciation, example) {
        const practiceWord = { word, meaning, pronunciation, example };
        sessionStorage.setItem('currentPracticeWord', JSON.stringify(practiceWord));
        
        practiceContent.innerHTML = `
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-brain text-blue-600 text-2xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-900 mb-4">What does this word mean?</h4>
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl p-8 mb-4">
                    <p class="text-3xl font-bold text-white">${word}</p>
                </div>
                ${pronunciation ? `
                    <div class="flex items-center justify-center space-x-2 text-gray-600 mb-2">
                        <i class="fas fa-volume-up"></i>
                        <span class="text-sm">${pronunciation}</span>
                    </div>
                ` : ''}
                <p class="text-gray-500 text-sm">Think about the meaning, then click "Show Answer"</p>
            </div>
        `;

        showAnswerBtn.classList.remove('hidden');
        nextWordBtn.classList.add('hidden');
        practiceModal.classList.remove('hidden');
    }

    function updateWordProgress(word) {
        // Simulate API call to update progress
        console.log(`Updating progress for word: ${word}`);
        // In real implementation, this would be an AJAX call to your backend
    }

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-xl text-white font-semibold z-50 transform transition-all duration-300 ${
            type === 'success' ? 'bg-green-500' : 'bg-blue-500'
        }`;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }

    // Close modal when clicking outside
    practiceModal.addEventListener('click', function(e) {
        if (e.target === practiceModal) {
            practiceModal.classList.add('hidden');
        }
    });

    // Pronunciation button functionality
    const pronunciationBtn = document.querySelector('.bg-blue-400');
    if (pronunciationBtn) {
        pronunciationBtn.addEventListener('click', function() {
            // Simulate pronunciation playback
            this.innerHTML = '<i class="fas fa-volume-up text-sm"></i>';
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-play text-sm"></i>';
            }, 1000);
        });
    }

    // Animate progress bars on load
    const progressBars = document.querySelectorAll('.bg-gray-200 .rounded-full');
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