@extends('layouts.app')

@section('title', 'Vocabulary - VocabMaster')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Vocabulary Library</h1>
                <p class="text-gray-600 mt-2">Explore and learn new words to enhance your language skills</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('words.practice') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-3 rounded-lg hover:from-green-600 hover:to-green-700 transition duration-200 font-semibold">
                    <i class="fas fa-play-circle"></i>
                    <span>Start Practice Session</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
        <form action="{{ route('words.index') }}" method="GET" class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-6">
            <!-- Search Input -->
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Words</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Search for words or meanings...">
                </div>
            </div>

            <!-- Category Filter -->
            <div class="md:w-48">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select name="category" id="category" class="block w-full py-3 px-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Difficulty Filter -->
            <div class="md:w-40">
                <label for="difficulty" class="block text-sm font-medium text-gray-700 mb-2">Difficulty</label>
                <select name="difficulty" id="difficulty" class="block w-full py-3 px-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Levels</option>
                    <option value="beginner" {{ request('difficulty') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                    <option value="intermediate" {{ request('difficulty') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                    <option value="advanced" {{ request('difficulty') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                </select>
            </div>

            <!-- Actions -->
            <div class="flex space-x-3">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition duration-200 font-semibold flex items-center space-x-2">
                    <i class="fas fa-filter"></i>
                    <span>Apply</span>
                </button>
                <a href="{{ route('words.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-300 transition duration-200 font-semibold flex items-center space-x-2">
                    <i class="fas fa-redo"></i>
                    <span>Reset</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Words Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($words as $word)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 card-hover">
                <div class="p-6">
                    <!-- Word Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $word->word }}</h3>
                            <div class="flex items-center space-x-2">
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
                        <form action="{{ route('favorites.toggle', $word) }}" method="POST">
                            @csrf
                            <button type="submit" class="p-2 rounded-lg hover:bg-gray-100 transition duration-200">
                                <i class="fas fa-star {{ $word->isFavoritedBy(Auth::user()) ? 'text-yellow-500' : 'text-gray-300' }} hover:text-yellow-400"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Pronunciation -->
                    @if($word->pronunciation)
                        <div class="flex items-center space-x-2 text-gray-600 mb-3">
                            <i class="fas fa-volume-up"></i>
                            <span class="text-sm">{{ $word->pronunciation }}</span>
                        </div>
                    @endif

                    <!-- Meaning -->
                    <p class="text-gray-700 mb-4 line-clamp-2">{{ $word->meaning }}</p>

                    <!-- Example Sentence -->
                    <div class="bg-gray-50 rounded-lg p-3 mb-4">
                        <p class="text-sm text-gray-600 italic">"{{ $word->example_sentence }}"</p>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between">
                        <a href="{{ route('words.show', $word) }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm flex items-center space-x-1">
                            <span>Learn More</span>
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                        
                        @if($word->getUserProgress(Auth::user()))
                            @php $progress = $word->getUserProgress(Auth::user()); @endphp
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-green-600 text-xs"></i>
                                </div>
                                <span class="text-xs text-gray-500">{{ $progress->accuracy }}% accuracy</span>
                            </div>
                        @else
                            <span class="text-xs text-gray-500">New word</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($words->hasPages())
        <div class="mt-8">
            {{ $words->links() }}
        </div>
    @endif

    <!-- Empty State -->
    @if($words->count() == 0)
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-search text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No words found</h3>
            <p class="text-gray-500 mb-6">Try adjusting your search criteria or browse all words</p>
            <a href="{{ route('words.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 font-semibold">
                Browse All Words
            </a>
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
</style>
@endsection