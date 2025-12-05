@extends('layouts.app')

@section('title', 'Quiz History - VocabMaster')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="text-center mb-12">
        <div class="w-20 h-20 bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-history text-white text-3xl"></i>
        </div>
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Quiz History</h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            Track your learning journey. Review your quiz attempts and monitor your progress over time.
        </p>
        <div class="mt-6 flex flex-wrap justify-center gap-4">
            <div class="flex items-center space-x-2 bg-purple-50 px-4 py-2 rounded-full">
                <i class="fas fa-chart-line text-purple-600"></i>
                <span class="text-sm font-medium text-purple-900">Progress Tracking</span>
            </div>
            <div class="flex items-center space-x-2 bg-blue-50 px-4 py-2 rounded-full">
                <i class="fas fa-trophy text-blue-600"></i>
                <span class="text-sm font-medium text-blue-900">Achievement History</span>
            </div>
            <div class="flex items-center space-x-2 bg-green-50 px-4 py-2 rounded-full">
                <i class="fas fa-analytics text-green-600"></i>
                <span class="text-sm font-medium text-green-900">Performance Analytics</span>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Attempts</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $attempts->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-list-alt text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Average Score</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ round($attempts->avg('percentage') ?? 0) }}%
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-chart-bar text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Best Score</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $attempts->max('percentage') ?? 0 }}%
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-trophy text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Time</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        @php
                            $totalSeconds = $attempts->sum('time_taken');
                            $hours = floor($totalSeconds / 3600);
                            $minutes = floor(($totalSeconds % 3600) / 60);
                        @endphp
                        {{ $hours }}h {{ $minutes }}m
                    </p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Actions -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <!-- Search and Filters -->
            <div class="flex flex-col sm:flex-row gap-4 flex-1">
                <!-- Search -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search Quizzes</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" 
                               placeholder="Search by quiz name..." 
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>
                </div>

                <!-- Date Filter -->
                <div class="sm:w-48">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Time Period</label>
                    <select class="block w-full py-3 px-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        <option value="all">All Time</option>
                        <option value="week">Last Week</option>
                        <option value="month">Last Month</option>
                        <option value="year">Last Year</option>
                    </select>
                </div>

                <!-- Sort By -->
                <div class="sm:w-40">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                    <select class="block w-full py-3 px-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="score_high">Score: High to Low</option>
                        <option value="score_low">Score: Low to High</option>
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-3">
                <button class="export-btn bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition duration-200 flex items-center space-x-2">
                    <i class="fas fa-download"></i>
                    <span>Export Data</span>
                </button>
                <a href="{{ route('quizzes.index') }}" 
                   class="bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-300 transition duration-200 flex items-center space-x-2">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Quizzes</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Quiz Attempts List -->
    <div class="space-y-6">
        @if($attempts->count() > 0)
            @foreach($attempts as $attempt)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden card-hover">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                        <!-- Quiz Info -->
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $attempt->quiz->title }}</h3>
                                    <div class="flex flex-wrap items-center gap-2">
                                        @if($attempt->quiz->category)
                                        <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                            <i class="fas fa-folder mr-1"></i>
                                            {{ $attempt->quiz->category->name }}
                                        </span>
                                        @endif
                                        <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">
                                            <i class="fas {{ $attempt->quiz->type == 'multiple_choice' ? 'fa-list-ul' : 'fa-edit' }} mr-1"></i>
                                            {{ $attempt->quiz->type == 'multiple_choice' ? 'Multiple Choice' : 'Fill in Blank' }}
                                        </span>
                                        @if($attempt->time_taken)
                                        <span class="inline-flex items-center px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-sm font-medium">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ floor($attempt->time_taken / 60) }}:{{ sprintf('%02d', $attempt->time_taken % 60) }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Score Badge -->
                                <div class="text-right">
                                    <div class="text-3xl font-bold {{ $attempt->percentage >= 70 ? 'text-green-600' : ($attempt->percentage >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ $attempt->percentage }}%
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $attempt->score }}/{{ $attempt->total_questions }} correct
                                    </div>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex justify-between text-sm text-gray-600 mb-2">
                                    <span>Performance</span>
                                    <span class="font-semibold">{{ $attempt->percentage }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="h-3 rounded-full {{ $attempt->percentage >= 70 ? 'bg-green-500' : ($attempt->percentage >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}" 
                                         style="width: {{ $attempt->percentage }}%"></div>
                                </div>
                            </div>

                            <!-- Additional Info -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-calendar text-gray-400"></i>
                                    <span class="text-gray-600">{{ $attempt->completed_at->format('M j, Y') }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-clock text-gray-400"></i>
                                    <span class="text-gray-600">{{ $attempt->completed_at->format('g:i A') }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-question-circle text-gray-400"></i>
                                    <span class="text-gray-600">{{ $attempt->total_questions }} questions</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-bolt text-gray-400"></i>
                                    <span class="text-gray-600">
                                        @if($attempt->percentage >= 80)
                                            Excellent
                                        @elseif($attempt->percentage >= 60)
                                            Good
                                        @elseif($attempt->percentage >= 40)
                                            Fair
                                        @else
                                            Needs Improvement
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="lg:w-48 flex flex-col space-y-3">
                            <a href="{{ route('quizzes.results', $attempt) }}" 
                               class="w-full bg-blue-600 text-white py-3 px-4 rounded-xl font-semibold text-center hover:bg-blue-700 transition duration-200 flex items-center justify-center space-x-2">
                                <i class="fas fa-chart-bar"></i>
                                <span>View Details</span>
                            </a>
                            <a href="{{ route('quizzes.start', $attempt->quiz) }}" 
                               class="w-full bg-green-600 text-white py-3 px-4 rounded-xl font-semibold text-center hover:bg-green-700 transition duration-200 flex items-center justify-center space-x-2">
                                <i class="fas fa-redo"></i>
                                <span>Retry Quiz</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Performance Insights -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <span class="text-sm font-medium text-gray-700">Performance Insights:</span>
                            @if($attempt->percentage >= 80)
                            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                                <i class="fas fa-fire mr-1"></i>
                                Outstanding Performance
                            </span>
                            @elseif($attempt->percentage >= 60)
                            <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                <i class="fas fa-thumbs-up mr-1"></i>
                                Good Understanding
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Room for Improvement
                            </span>
                            @endif
                        </div>
                        <span class="text-sm text-gray-500">
                            {{ $attempt->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Pagination -->
            @if($attempts->hasPages())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-4">
                {{ $attempts->links() }}
            </div>
            @endif

        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-history text-gray-400 text-5xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">No Quiz History Yet</h3>
                <p class="text-gray-600 max-w-md mx-auto mb-8">
                    You haven't taken any quizzes yet. Start your learning journey by taking your first quiz!
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('quizzes.index') }}" 
                       class="inline-flex items-center space-x-2 bg-blue-600 text-white px-8 py-4 rounded-xl hover:bg-blue-700 transition duration-200 font-semibold">
                        <i class="fas fa-tasks"></i>
                        <span>Browse Quizzes</span>
                    </a>
                    <a href="{{ route('words.index') }}" 
                       class="inline-flex items-center space-x-2 bg-green-600 text-white px-8 py-4 rounded-xl hover:bg-green-700 transition duration-200 font-semibold">
                        <i class="fas fa-book-open"></i>
                        <span>Study Words</span>
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Performance Analytics Section -->
    @if($attempts->count() > 0)
    <div class="mt-12">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-chart-line text-purple-500 mr-3"></i>
                Performance Analytics
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Score Distribution -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Score Distribution</h3>
                    <div class="space-y-3">
                        @php
                            $excellent = $attempts->where('percentage', '>=', 80)->count();
                            $good = $attempts->whereBetween('percentage', [60, 79])->count();
                            $fair = $attempts->whereBetween('percentage', [40, 59])->count();
                            $poor = $attempts->where('percentage', '<', 40)->count();
                            $total = $attempts->count();
                        @endphp
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-green-700">Excellent (80-100%)</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-32 bg-gray-200 rounded-full h-3">
                                    <div class="bg-green-500 h-3 rounded-full" style="width: {{ ($excellent / $total) * 100 }}%"></div>
                                </div>
                                <span class="text-sm text-gray-600 w-8">{{ $excellent }}</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-blue-700">Good (60-79%)</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-32 bg-gray-200 rounded-full h-3">
                                    <div class="bg-blue-500 h-3 rounded-full" style="width: {{ ($good / $total) * 100 }}%"></div>
                                </div>
                                <span class="text-sm text-gray-600 w-8">{{ $good }}</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-yellow-700">Fair (40-59%)</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-32 bg-gray-200 rounded-full h-3">
                                    <div class="bg-yellow-500 h-3 rounded-full" style="width: {{ ($fair / $total) * 100 }}%"></div>
                                </div>
                                <span class="text-sm text-gray-600 w-8">{{ $fair }}</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-red-700">Needs Improvement (0-39%)</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-32 bg-gray-200 rounded-full h-3">
                                    <div class="bg-red-500 h-3 rounded-full" style="width: {{ ($poor / $total) * 100 }}%"></div>
                                </div>
                                <span class="text-sm text-gray-600 w-8">{{ $poor }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Progress -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Progress Trend</h3>
                    <div class="space-y-4">
                        @php
                            $recentAttempts = $attempts->take(5);
                            $maxScore = max($recentAttempts->max('percentage'), 100);
                        @endphp
                        
                        @foreach($recentAttempts as $recent)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3 flex-1">
                                <span class="text-sm text-gray-600 w-24 truncate">{{ $recent->quiz->title }}</span>
                                <div class="flex-1 bg-gray-200 rounded-full h-3">
                                    <div class="h-3 rounded-full {{ $recent->percentage >= 70 ? 'bg-green-500' : ($recent->percentage >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}" 
                                         style="width: {{ ($recent->percentage / $maxScore) * 100 }}%"></div>
                                </div>
                            </div>
                            <span class="text-sm font-semibold {{ $recent->percentage >= 70 ? 'text-green-600' : ($recent->percentage >= 50 ? 'text-yellow-600' : 'text-red-600') }} w-12 text-right">
                                {{ $recent->percentage }}%
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 5px 10px -5px rgba(0, 0, 0, 0.04);
}

.performance-excellent {
    border-left: 4px solid #10B981;
}

.performance-good {
    border-left: 4px solid #3B82F6;
}

.performance-fair {
    border-left: 4px solid #F59E0B;
}

.performance-poor {
    border-left: 4px solid #EF4444;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Export functionality
    const exportBtn = document.querySelector('.export-btn');
    if (exportBtn) {
        exportBtn.addEventListener('click', function() {
            // Simulate export functionality
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg font-semibold z-50';
            toast.textContent = 'Exporting quiz history data...';
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
                // In a real implementation, this would trigger a file download
                alert('Your quiz history data has been exported successfully!');
            }, 2000);
        });
    }

    // Add performance classes to attempt cards
    document.querySelectorAll('.bg-white.rounded-2xl').forEach(card => {
        const percentage = parseInt(card.querySelector('.text-3xl').textContent);
        if (percentage >= 80) {
            card.classList.add('performance-excellent');
        } else if (percentage >= 60) {
            card.classList.add('performance-good');
        } else if (percentage >= 40) {
            card.classList.add('performance-fair');
        } else {
            card.classList.add('performance-poor');
        }
    });

    // Animate progress bars on scroll
    const progressBars = document.querySelectorAll('.bg-gray-200 .rounded-full');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const bar = entry.target;
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.transition = 'width 1s ease-in-out';
                    bar.style.width = width;
                }, 100);
                observer.unobserve(bar);
            }
        });
    }, { threshold: 0.1 });

    progressBars.forEach(bar => observer.observe(bar));

    // Filter functionality
    const searchInput = document.querySelector('input[type="text"]');
    const timeFilter = document.querySelector('select:nth-of-type(1)');
    const sortFilter = document.querySelector('select:nth-of-type(2)');

    [searchInput, timeFilter, sortFilter].forEach(element => {
        if (element) {
            element.addEventListener('change', function() {
                // In a real implementation, this would filter the attempts
                console.log('Filter applied:', {
                    search: searchInput?.value,
                    time: timeFilter?.value,
                    sort: sortFilter?.value
                });
            });
        }
    });
});
</script>
@endsection