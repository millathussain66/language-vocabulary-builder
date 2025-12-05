@extends('layouts.app')

@section('title', 'Quizzes - VocabMaster')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Test Your Knowledge</h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Challenge yourself with our carefully crafted quizzes. Track your progress and improve your vocabulary skills.
        </p>
        <div class="mt-6 flex flex-wrap justify-center gap-4">
            <div class="flex items-center space-x-2 bg-blue-50 px-4 py-2 rounded-full">
                <i class="fas fa-trophy text-blue-600"></i>
                <span class="text-sm font-medium text-blue-900">Interactive Learning</span>
            </div>
            <div class="flex items-center space-x-2 bg-green-50 px-4 py-2 rounded-full">
                <i class="fas fa-chart-line text-green-600"></i>
                <span class="text-sm font-medium text-green-900">Progress Tracking</span>
            </div>
            <div class="flex items-center space-x-2 bg-purple-50 px-4 py-2 rounded-full">
                <i class="fas fa-clock text-purple-600"></i>
                <span class="text-sm font-medium text-purple-900">Timed Challenges</span>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Quizzes</p>
                    <p class="text-3xl font-bold mt-2">{{ $quizzes->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-400 rounded-full flex items-center justify-center">
                    <i class="fas fa-tasks text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Available Categories</p>
                    <p class="text-3xl font-bold mt-2">{{ $categories->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-400 rounded-full flex items-center justify-center">
                    <i class="fas fa-folder text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Quiz Types</p>
                    <p class="text-3xl font-bold mt-2">2</p>
                </div>
                <div class="w-12 h-12 bg-purple-400 rounded-full flex items-center justify-center">
                    <i class="fas fa-puzzle-piece text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
            <!-- Search Bar -->
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Search Quizzes</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" 
                           placeholder="Search by quiz title or description..." 
                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>
            </div>

            <!-- Category Filter -->
            <div class="lg:w-64">
                <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Category</label>
                <select class="block w-full py-3 px-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Quiz Type Filter -->
            <div class="lg:w-48">
                <label class="block text-sm font-medium text-gray-700 mb-2">Quiz Type</label>
                <select class="block w-full py-3 px-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    <option value="">All Types</option>
                    <option value="multiple_choice">Multiple Choice</option>
                    <option value="fill_blank">Fill in the Blank</option>
                </select>
            </div>

            <!-- Sort Options -->
            <div class="lg:w-40">
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                <select class="block w-full py-3 px-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    <option value="newest">Newest First</option>
                    <option value="popular">Most Popular</option>
                    <option value="difficulty">Difficulty</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Quiz Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        @foreach($quizzes as $quiz)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden card-hover group">
                <!-- Quiz Header with Gradient -->
                <div class="h-2 bg-gradient-to-r from-{{ $quiz->type == 'multiple_choice' ? 'blue' : 'green' }}-500 to-{{ $quiz->type == 'multiple_choice' ? 'purple' : 'teal' }}-600"></div>
                
                <div class="p-6">
                    <!-- Quiz Type Badge -->
                    <div class="flex justify-between items-start mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                            {{ $quiz->type == 'multiple_choice' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                            <i class="fas {{ $quiz->type == 'multiple_choice' ? 'fa-list-ul' : 'fa-edit' }} mr-1"></i>
                            {{ $quiz->type == 'multiple_choice' ? 'Multiple Choice' : 'Fill in Blank' }}
                        </span>
                        @if($quiz->time_limit)
                            <span class="inline-flex items-center px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-xs font-medium">
                                <i class="fas fa-clock mr-1"></i>
                                {{ $quiz->time_limit }}min
                            </span>
                        @endif
                    </div>

                    <!-- Quiz Title and Description -->
                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition duration-200">
                        {{ $quiz->title }}
                    </h3>
                    
                    @if($quiz->description)
                        <p class="text-gray-600 mb-4 line-clamp-2">{{ $quiz->description }}</p>
                    @endif

                    <!-- Category and Difficulty -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs">
                                <i class="fas fa-folder mr-1"></i>
                                {{ $quiz->category->name ?? 'General' }}
                            </span>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-medium text-gray-500">{{ $quiz->question_count }} questions</span>
                        </div>
                    </div>

                    <!-- Progress Stats -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Average Score</span>
                            <span class="font-semibold">75%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: 75%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                            <span>{{ $quiz->attempts->count() }} attempts</span>
                            <span>Last week: +12%</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-3">
                        <a href="{{ route('quizzes.show', $quiz) }}" 
                           class="flex-1 bg-gray-100 text-gray-700 py-3 px-4 rounded-lg font-semibold text-center hover:bg-gray-200 transition duration-200 flex items-center justify-center space-x-2">
                            <i class="fas fa-info-circle"></i>
                            <span>Details</span>
                        </a>
                        <a href="{{ route('quizzes.start', $quiz) }}" 
                           class="flex-1 bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 px-4 rounded-lg font-semibold text-center hover:from-blue-600 hover:to-purple-700 transition duration-200 transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                            <i class="fas fa-play"></i>
                            <span>Start Quiz</span>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Empty State -->
    @if($quizzes->count() == 0)
        <div class="text-center py-16">
            <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-tasks text-gray-400 text-5xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">No Quizzes Available</h3>
            <p class="text-gray-600 max-w-md mx-auto mb-8">
                It looks like there are no quizzes available at the moment. Check back later for new challenges!
            </p>
            <a href="{{ route('dashboard') }}" 
               class="inline-flex items-center space-x-2 bg-blue-600 text-white px-8 py-4 rounded-xl hover:bg-blue-700 transition duration-200 font-semibold">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Dashboard</span>
            </a>
        </div>
    @endif

    <!-- Featured Categories Section -->
    <div class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Browse by Category</h2>
            <a href="{{ route('words.index') }}" class="text-blue-600 hover:text-blue-500 font-semibold flex items-center space-x-2">
                <span>View All Categories</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($categories->take(4) as $category)
                <a href="{{ route('words.index', ['category' => $category->id]) }}" 
                   class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center card-hover group">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center group-hover:from-blue-600 group-hover:to-purple-700 transition duration-200">
                        <i class="fas fa-folder text-white text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-500 mb-3">{{ $category->word_count }} words</p>
                    <span class="inline-block px-3 py-1 text-xs font-medium rounded-full 
                        {{ $category->difficulty == 'beginner' ? 'bg-green-100 text-green-800' : 
                           ($category->difficulty == 'intermediate' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($category->difficulty) }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Quick Stats & Call to Action -->
    <div class="bg-gradient-to-r from-gray-900 to-blue-900 rounded-2xl text-white p-8 mb-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to Boost Your Vocabulary?</h2>
            <p class="text-blue-200 text-lg mb-8 max-w-2xl mx-auto">
                Join thousands of learners who have improved their language skills with our interactive quizzes and vocabulary exercises.
            </p>
            <div class="flex flex-wrap justify-center gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-400 mb-1">10k+</div>
                    <div class="text-blue-200 text-sm">Quizzes Completed</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-400 mb-1">95%</div>
                    <div class="text-blue-200 text-sm">Success Rate</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-purple-400 mb-1">2.5k</div>
                    <div class="text-blue-200 text-sm">Active Learners</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($quizzes->hasPages())
        <div class="flex justify-center">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-4">
                {{ $quizzes->links() }}
            </div>
        </div>
    @endif
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .card-hover {
        transition: all 0.3s ease;
    }
    
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>

<script>
    // Add some interactive functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Add click animation to quiz cards
        const quizCards = document.querySelectorAll('.card-hover');
        quizCards.forEach(card => {
            card.addEventListener('click', function(e) {
                if (e.target.tagName === 'A') return;
                const startBtn = this.querySelector('a[href*="start"]');
                if (startBtn) {
                    startBtn.click();
                }
            });
        });

        // Filter functionality
        const searchInput = document.querySelector('input[type="text"]');
        const categoryFilter = document.querySelector('select:nth-of-type(1)');
        const typeFilter = document.querySelector('select:nth-of-type(2)');
        const sortFilter = document.querySelector('select:nth-of-type(3)');

        [searchInput, categoryFilter, typeFilter, sortFilter].forEach(element => {
            if (element) {
                element.addEventListener('change', function() {
                    // In a real implementation, this would filter the quizzes
                    console.log('Filter applied:', {
                        search: searchInput?.value,
                        category: categoryFilter?.value,
                        type: typeFilter?.value,
                        sort: sortFilter?.value
                    });
                });
            }
        });
    });
</script>
@endsection