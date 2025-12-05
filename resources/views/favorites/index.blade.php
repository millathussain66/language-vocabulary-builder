@extends('layouts.app')

@section('title', 'My Favorites - VocabMaster')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="text-center mb-12">
        <div class="w-20 h-20 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-star text-white text-3xl"></i>
        </div>
        <h1 class="text-4xl font-bold text-gray-900 mb-4">My Favorite Words</h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            Your personal collection of words. Review them regularly to strengthen your vocabulary.
        </p>
        <div class="mt-6 flex flex-wrap justify-center gap-4">
            <div class="flex items-center space-x-2 bg-yellow-50 px-4 py-2 rounded-full">
                <i class="fas fa-heart text-yellow-600"></i>
                <span class="text-sm font-medium text-yellow-900">Personal Collection</span>
            </div>
            <div class="flex items-center space-x-2 bg-blue-50 px-4 py-2 rounded-full">
                <i class="fas fa-sync-alt text-blue-600"></i>
                <span class="text-sm font-medium text-blue-900">Regular Review</span>
            </div>
            <div class="flex items-center space-x-2 bg-green-50 px-4 py-2 rounded-full">
                <i class="fas fa-chart-line text-green-600"></i>
                <span class="text-sm font-medium text-green-900">Progress Tracking</span>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Favorites</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $favoriteWords->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-star text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Mastered Words</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $favoriteWords->where('pivot.mastered', true)->count() }}
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
                        {{ $favoriteWords->where('pivot.mastered', false)->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-sync-alt text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Categories</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $favoriteWords->pluck('category_id')->unique()->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-folder text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Bar -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-center space-x-4">
                <h3 class="text-lg font-semibold text-gray-900">My Favorite Words</h3>
                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                    {{ $favoriteWords->count() }} words
                </span>
            </div>
            
            <div class="flex flex-wrap gap-3">
                <button id="practice-all-btn" class="inline-flex items-center space-x-2 bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-700 transition duration-200 font-semibold">
                    <i class="fas fa-play-circle"></i>
                    <span>Practice All</span>
                </button>
                
                <button id="export-btn" class="inline-flex items-center space-x-2 bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition duration-200 font-semibold">
                    <i class="fas fa-download"></i>
                    <span>Export List</span>
                </button>
                
                <div class="relative">
                    <select id="sort-select" class="appearance-none bg-gray-100 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-200 transition duration-200 font-semibold pr-10 cursor-pointer">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="alphabetical">A to Z</option>
                        <option value="difficulty">Difficulty</option>
                        <option value="category">Category</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-500"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Favorites Grid -->
    @if($favoriteWords->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($favoriteWords as $word)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 card-hover group relative">
                    <!-- Favorite Indicator -->
                    <div class="absolute top-4 right-4">
                        <form action="{{ route('favorites.destroy', $word) }}" method="POST" class="favorite-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-yellow-100 rounded-full hover:bg-yellow-200 transition duration-200 transform hover:scale-110">
                                <i class="fas fa-star text-yellow-500 text-lg"></i>
                            </button>
                        </form>
                    </div>

                    <div class="p-6">
                        <!-- Word Header -->
                        <div class="mb-4">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition duration-200">
                                {{ $word->word }}
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    {{ $word->difficulty == 'beginner' ? 'bg-green-100 text-green-800' : 
                                       ($word->difficulty == 'intermediate' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($word->difficulty) }}
                                </span>
                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                    {{ $word->category->name }}
                                </span>
                            </div>
                        </div>

                        <!-- Pronunciation -->
                        @if($word->pronunciation)
                            <div class="flex items-center space-x-2 text-gray-600 mb-3">
                                <i class="fas fa-volume-up text-sm"></i>
                                <span class="text-sm">{{ $word->pronunciation }}</span>
                            </div>
                        @endif

                        <!-- Meaning -->
                        <p class="text-gray-700 mb-4 line-clamp-2">{{ $word->meaning }}</p>

                        <!-- Example Sentence -->
                        <div class="bg-gray-50 rounded-lg p-3 mb-4">
                            <p class="text-sm text-gray-600 italic">"{{ $word->example_sentence }}"</p>
                        </div>

                        <!-- Progress Stats -->
                        @if($word->userProgress)
                            @php $progress = $word->userProgress->first(); @endphp
                            <div class="mb-4">
                                <div class="flex justify-between text-sm text-gray-600 mb-2">
                                    <span>Your Progress</span>
                                    <span class="font-semibold">{{ $progress->accuracy ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full transition-all duration-300" 
                                         style="width: {{ $progress->accuracy ?? 0 }}%"></div>
                                </div>
                                <div class="flex justify-between text-xs text-gray-500 mt-1">
                                    <span>Seen: {{ $progress->times_seen ?? 0 }}x</span>
                                    <span>Correct: {{ $progress->times_correct ?? 0 }}x</span>
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex space-x-2">
                            <a href="{{ route('words.show', $word) }}" 
                               class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg text-sm font-semibold text-center hover:bg-blue-700 transition duration-200 flex items-center justify-center space-x-2">
                                <i class="fas fa-eye"></i>
                                <span>Review</span>
                            </a>
                            <button class="practice-word-btn bg-green-600 text-white py-2 px-4 rounded-lg text-sm font-semibold hover:bg-green-700 transition duration-200 flex items-center justify-center space-x-2"
                                    data-word-id="{{ $word->id }}"
                                    data-word="{{ $word->word }}"
                                    data-meaning="{{ $word->meaning }}">
                                <i class="fas fa-play"></i>
                                <span>Practice</span>
                            </button>
                        </div>

                        <!-- Added Date -->
                        <div class="text-xs text-gray-500 mt-3 text-center">
                            Added {{ $word->pivot->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($favoriteWords->hasPages())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-4">
                {{ $favoriteWords->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-star text-gray-400 text-5xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">No Favorite Words Yet</h3>
            <p class="text-gray-600 max-w-md mx-auto mb-8">
                Start building your personal vocabulary collection by adding words you want to remember.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('words.index') }}" 
                   class="inline-flex items-center space-x-2 bg-blue-600 text-white px-8 py-4 rounded-xl hover:bg-blue-700 transition duration-200 font-semibold">
                    <i class="fas fa-book-open"></i>
                    <span>Browse Words</span>
                </a>
                <a href="{{ route('quizzes.index') }}" 
                   class="inline-flex items-center space-x-2 bg-green-600 text-white px-8 py-4 rounded-xl hover:bg-green-700 transition duration-200 font-semibold">
                    <i class="fas fa-tasks"></i>
                    <span>Take a Quiz</span>
                </a>
            </div>
        </div>
    @endif

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
                
                <div id="practice-content" class="space-y-4">
                    <!-- Content will be loaded here -->
                </div>
                
                <div class="flex space-x-3 mt-6">
                    <button id="show-answer" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition duration-200">
                        Show Answer
                    </button>
                    <button id="next-word" class="flex-1 bg-green-600 text-white py-3 rounded-xl font-semibold hover:bg-green-700 transition duration-200">
                        Next Word
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

.favorite-form button {
    transition: all 0.2s ease;
}

.favorite-form button:hover i {
    transform: scale(1.1);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const practiceModal = document.getElementById('practice-modal');
    const practiceContent = document.getElementById('practice-content');
    const closeModal = document.getElementById('close-modal');
    const showAnswerBtn = document.getElementById('show-answer');
    const nextWordBtn = document.getElementById('next-word');
    const practiceAllBtn = document.getElementById('practice-all-btn');
    const exportBtn = document.getElementById('export-btn');
    const sortSelect = document.getElementById('sort-select');
    
    let currentPracticeIndex = 0;
    let practiceWords = [];

    // Practice single word
    document.querySelectorAll('.practice-word-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const wordId = this.dataset.wordId;
            const word = this.dataset.word;
            const meaning = this.dataset.meaning;
            
            practiceWords = [{
                id: wordId,
                word: word,
                meaning: meaning,
                element: this.closest('.card-hover')
            }];
            
            currentPracticeIndex = 0;
            startPracticeSession();
        });
    });

    // Practice all words
    practiceAllBtn.addEventListener('click', function() {
        practiceWords = Array.from(document.querySelectorAll('.practice-word-btn')).map(btn => ({
            id: btn.dataset.wordId,
            word: btn.dataset.word,
            meaning: btn.dataset.meaning,
            element: btn.closest('.card-hover')
        }));
        
        if (practiceWords.length > 0) {
            currentPracticeIndex = 0;
            startPracticeSession();
        } else {
            alert('No words to practice!');
        }
    });

    // Export functionality
    exportBtn.addEventListener('click', function() {
        const words = Array.from(document.querySelectorAll('.card-hover')).map(card => {
            const word = card.querySelector('h3').textContent.trim();
            const meaning = card.querySelector('p.text-gray-700').textContent.trim();
            return { word, meaning };
        });
        
        const csvContent = "Word,Meaning\n" + 
            words.map(word => `"${word.word}","${word.meaning}"`).join("\n");
        
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'my-favorite-words.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
        
        // Show success message
        showNotification('Your favorite words have been exported successfully!', 'success');
    });

    // Sort functionality
    sortSelect.addEventListener('change', function() {
        // In a real implementation, this would reload the page with new sorting
        // or sort client-side if the data is already loaded
        showNotification(`Sorted by: ${this.options[this.selectedIndex].text}`, 'info');
    });

    // Close modal
    closeModal.addEventListener('click', function() {
        practiceModal.classList.add('hidden');
    });

    // Show answer
    showAnswerBtn.addEventListener('click', function() {
        const currentWord = practiceWords[currentPracticeIndex];
        practiceContent.innerHTML = `
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-lightbulb text-green-600 text-2xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-900 mb-2">${currentWord.word}</h4>
                <p class="text-lg text-gray-700">${currentWord.meaning}</p>
            </div>
        `;
        
        // Mark word as reviewed in the UI
        if (currentWord.element) {
            const progressBar = currentWord.element.querySelector('.bg-green-500');
            if (progressBar) {
                const currentWidth = parseInt(progressBar.style.width) || 0;
                progressBar.style.width = Math.min(currentWidth + 20, 100) + '%';
            }
        }
    });

    // Next word
    nextWordBtn.addEventListener('click', function() {
        currentPracticeIndex++;
        if (currentPracticeIndex < practiceWords.length) {
            loadPracticeWord();
        } else {
            practiceModal.classList.add('hidden');
            showNotification('Practice session completed!', 'success');
        }
    });

    function startPracticeSession() {
        loadPracticeWord();
        practiceModal.classList.remove('hidden');
    }

    function loadPracticeWord() {
        const currentWord = practiceWords[currentPracticeIndex];
        practiceContent.innerHTML = `
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-brain text-blue-600 text-2xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-900 mb-4">What does this word mean?</h4>
                <div class="bg-gray-100 rounded-xl p-6 mb-4">
                    <p class="text-3xl font-bold text-gray-900">${currentWord.word}</p>
                </div>
                <p class="text-sm text-gray-500">Think about the meaning, then click "Show Answer"</p>
            </div>
        `;
        
        // Update buttons
        showAnswerBtn.style.display = 'block';
        if (currentPracticeIndex === practiceWords.length - 1) {
            nextWordBtn.textContent = 'Finish';
        } else {
            nextWordBtn.textContent = 'Next Word';
        }
    }

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-xl text-white font-semibold z-50 transform transition-all duration-300 ${
            type === 'success' ? 'bg-green-500' : 'bg-blue-500'
        }`;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
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