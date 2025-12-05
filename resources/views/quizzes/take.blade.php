@extends('layouts.app')

@section('title', $quiz->title . ' - Take Quiz - VocabMaster')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Quiz Header -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
            <div class="flex-1">
                <!-- Breadcrumb -->
                <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
                    <a href="{{ route('quizzes.index') }}" class="hover:text-blue-600 transition duration-200">
                        <i class="fas fa-arrow-left"></i>
                        Back to Quizzes
                    </a>
                    <span class="text-gray-300">•</span>
                    <span>Taking Quiz</span>
                </nav>

                <!-- Quiz Title and Info -->
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $quiz->title }}</h1>
                
                <div class="flex flex-wrap items-center gap-4 mb-4">
                    @if($quiz->category)
                    <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                        <i class="fas fa-folder mr-2"></i>
                        {{ $quiz->category->name }}
                    </span>
                    @endif
                    
                    <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">
                        <i class="fas {{ $quiz->type == 'multiple_choice' ? 'fa-list-ul' : 'fa-edit' }} mr-2"></i>
                        {{ $quiz->type == 'multiple_choice' ? 'Multiple Choice' : 'Fill in Blank' }}
                    </span>

                    @if($quiz->time_limit)
                    <span class="inline-flex items-center px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-sm font-medium">
                        <i class="fas fa-clock mr-2"></i>
                        {{ $quiz->time_limit }} minutes
                    </span>
                    @endif

                    <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                        <i class="fas fa-question-circle mr-2"></i>
                        {{ $quiz->questions->count() }} questions
                    </span>
                </div>

                @if($quiz->description)
                <p class="text-gray-600 text-lg leading-relaxed">{{ $quiz->description }}</p>
                @endif
            </div>

            <!-- Quiz Timer & Progress -->
            <div class="lg:w-64">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 text-center">
                    @if($quiz->time_limit)
                    <!-- Timer -->
                    <div class="mb-6">
                        <div class="text-sm text-blue-700 font-medium mb-2">TIME REMAINING</div>
                        <div id="timer" class="text-3xl font-bold text-blue-900" data-time-limit="{{ $quiz->time_limit * 60 }}">
                            {{ sprintf('%02d:%02d', $quiz->time_limit, 0) }}
                        </div>
                        <div class="text-xs text-blue-600 mt-1">minutes:seconds</div>
                    </div>
                    @endif

                    <!-- Progress -->
                    <div>
                        <div class="text-sm text-blue-700 font-medium mb-2">PROGRESS</div>
                        <div class="text-2xl font-bold text-blue-900">
                            <span id="current-question">1</span>/{{ $quiz->questions->count() }}
                        </div>
                        <div class="w-full bg-blue-200 rounded-full h-2 mt-2">
                            <div id="progress-bar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quiz Instructions -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 mb-8">
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <i class="fas fa-lightbulb text-yellow-600 text-2xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-yellow-900 mb-2">Quiz Instructions</h3>
                <ul class="text-yellow-800 space-y-1">
                    <li class="flex items-center space-x-2">
                        <i class="fas fa-check text-yellow-600 text-xs"></i>
                        <span>Read each question carefully before answering</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="fas fa-check text-yellow-600 text-xs"></i>
                        <span>You can navigate between questions using the buttons</span>
                    </li>
                    @if($quiz->time_limit)
                    <li class="flex items-center space-x-2">
                        <i class="fas fa-check text-yellow-600 text-xs"></i>
                        <span>The quiz is timed - keep an eye on the timer!</span>
                    </li>
                    @endif
                    <li class="flex items-center space-x-2">
                        <i class="fas fa-check text-yellow-600 text-xs"></i>
                        <span>Submit your answers when you're finished</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Quiz Form -->
    <form id="quiz-form" action="{{ route('quizzes.submit', $quiz) }}" method="POST">
        @csrf
        <input type="hidden" name="time_taken" id="time-taken" value="0">

        <!-- Questions Container -->
        <div class="space-y-6" id="questions-container">
            @foreach($quiz->questions as $index => $question)
            <div class="question-section bg-white rounded-2xl shadow-sm border border-gray-100 p-6 transition-all duration-300 {{ $index === 0 ? 'current-question' : 'hidden' }}" 
                 data-question-index="{{ $index }}">
                
                <!-- Question Header -->
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-lg">{{ $index + 1 }}</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Question {{ $index + 1 }}</h3>
                            <p class="text-sm text-gray-500">{{ $question->points }} point{{ $question->points > 1 ? 's' : '' }}</p>
                        </div>
                    </div>
                    
                    @if($question->type == 'multiple_choice')
                    <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                        <i class="fas fa-list-ul mr-1"></i>
                        Multiple Choice
                    </span>
                    @endif
                </div>

                <!-- Question Text -->
                <div class="mb-6">
                    <p class="text-xl text-gray-900 font-medium leading-relaxed">{{ $question->question }}</p>
                </div>

                <!-- Options -->
                <div class="space-y-4">
                    @if($question->type == 'multiple_choice')
                        <!-- Multiple Choice Options -->
                        <div class="grid gap-4">
                            @foreach(['A', 'B', 'C', 'D'] as $option)
                                @if($question->{'option_' . strtolower($option)})
                                <label class="option-label flex items-start space-x-4 p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 hover:bg-blue-50 transition-all duration-200 group">
                                    <input type="radio" name="question_{{ $question->id }}" value="{{ $option }}" class="mt-1 transform scale-125 hidden">
                                    <div class="flex-shrink-0 w-8 h-8 border-2 border-gray-300 rounded-full flex items-center justify-center group-hover:border-blue-500 transition-colors duration-200 option-circle">
                                        <span class="text-sm font-semibold text-gray-600 group-hover:text-blue-600">{{ $option }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-gray-900 font-medium group-hover:text-blue-900">{{ $question->{'option_' . strtolower($option)} }}</p>
                                    </div>
                                    <div class="option-check hidden flex-shrink-0">
                                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                    </div>
                                </label>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <!-- Fill in the Blank -->
                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-xl p-6">
                                <label for="answer_{{ $question->id }}" class="block text-sm font-medium text-gray-700 mb-3">
                                    Your Answer:
                                </label>
                                <input type="text" 
                                       name="question_{{ $question->id }}" 
                                       id="answer_{{ $question->id }}"
                                       placeholder="Type your answer here..."
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-lg">
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200">
                    <button type="button" 
                            class="nav-btn prev-btn inline-flex items-center space-x-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition duration-200 font-semibold {{ $index === 0 ? 'invisible' : '' }}">
                        <i class="fas fa-arrow-left"></i>
                        <span>Previous</span>
                    </button>

                    @if($index === count($quiz->questions) - 1)
                    <button type="submit" 
                            class="inline-flex items-center space-x-2 px-8 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:from-green-600 hover:to-green-700 transition duration-200 font-semibold transform hover:-translate-y-0.5">
                        <i class="fas fa-paper-plane"></i>
                        <span>Submit Quiz</span>
                    </button>
                    @else
                    <button type="button" 
                            class="nav-btn next-btn inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-xl hover:from-blue-600 hover:to-purple-700 transition duration-200 font-semibold">
                        <span>Next Question</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </form>

    <!-- Quick Navigation -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mt-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Question Navigation</h3>
        <div class="grid grid-cols-5 md:grid-cols-10 gap-2">
            @foreach($quiz->questions as $index => $question)
            <button type="button" 
                    class="question-nav-btn w-10 h-10 rounded-lg border-2 font-semibold transition-all duration-200 
                           {{ $index === 0 ? 'border-blue-500 bg-blue-500 text-white' : 'border-gray-300 text-gray-700 hover:border-blue-400 hover:bg-blue-50' }}"
                    data-question-index="{{ $index }}">
                {{ $index + 1 }}
            </button>
            @endforeach
        </div>
    </div>
</div>

<style>
.option-label.selected {
    border-color: #10B981;
    background-color: #F0FDF4;
}

.option-label.selected .option-circle {
    border-color: #10B981;
    background-color: #10B981;
}

.option-label.selected .option-circle span {
    color: white;
}

.option-label.selected .option-check {
    display: block;
}

.question-section {
    opacity: 1;
    transform: translateX(0);
}

.question-section.hidden {
    display: none;
}

.question-section.slide-out-left {
    animation: slideOutLeft 0.3s ease-in-out;
}

.question-section.slide-in-right {
    animation: slideInRight 0.3s ease-in-out;
}

.question-section.slide-out-right {
    animation: slideOutRight 0.3s ease-in-out;
}

.question-section.slide-in-left {
    animation: slideInLeft 0.3s ease-in-out;
}

@keyframes slideOutLeft {
    from { transform: translateX(0); opacity: 1; }
    to { transform: translateX(-100%); opacity: 0; }
}

@keyframes slideInRight {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes slideOutRight {
    from { transform: translateX(0); opacity: 1; }
    to { transform: translateX(100%); opacity: 0; }
}

@keyframes slideInLeft {
    from { transform: translateX(-100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quizForm = document.getElementById('quiz-form');
    const questions = document.querySelectorAll('.question-section');
    const questionNavBtns = document.querySelectorAll('.question-nav-btn');
    const currentQuestionSpan = document.getElementById('current-question');
    const progressBar = document.getElementById('progress-bar');
    const timeTakenInput = document.getElementById('time-taken');
    const totalQuestions = questions.length;
    
    let currentQuestionIndex = 0;
    let startTime = new Date();
    let timerInterval;

    // Initialize timer if quiz has time limit
    @if($quiz->time_limit)
    initializeTimer();
    @endif

    // Update progress
    updateProgress();

    // Multiple choice option selection
    document.querySelectorAll('.option-label').forEach(label => {
        label.addEventListener('click', function() {
            const questionSection = this.closest('.question-section');
            questionSection.querySelectorAll('.option-label').forEach(opt => {
                opt.classList.remove('selected');
            });
            this.classList.add('selected');
            this.querySelector('input[type="radio"]').checked = true;
        });
    });

    // Navigation buttons
    document.querySelectorAll('.nav-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.classList.contains('next-btn')) {
                navigateToQuestion(currentQuestionIndex + 1);
            } else if (this.classList.contains('prev-btn')) {
                navigateToQuestion(currentQuestionIndex - 1);
            }
        });
    });

    // Question navigation buttons
    questionNavBtns.forEach((btn, index) => {
        btn.addEventListener('click', function() {
            navigateToQuestion(index);
        });
    });

    // Form submission
    quizForm.addEventListener('submit', function(e) {
        const endTime = new Date();
        const timeTaken = Math.floor((endTime - startTime) / 1000);
        timeTakenInput.value = timeTaken;

        // Show confirmation dialog
        if (!confirm('Are you sure you want to submit your quiz? You cannot change your answers after submission.')) {
            e.preventDefault();
        }
    });

    function navigateToQuestion(targetIndex) {
        if (targetIndex < 0 || targetIndex >= totalQuestions) return;

        const currentQuestion = questions[currentQuestionIndex];
        const targetQuestion = questions[targetIndex];
        const direction = targetIndex > currentQuestionIndex ? 'right' : 'left';

        // Animation classes
        currentQuestion.classList.add(direction === 'right' ? 'slide-out-left' : 'slide-out-right');
        
        setTimeout(() => {
            currentQuestion.classList.add('hidden');
            currentQuestion.classList.remove('slide-out-left', 'slide-out-right');
            
            targetQuestion.classList.remove('hidden');
            targetQuestion.classList.add(direction === 'right' ? 'slide-in-right' : 'slide-in-left');
            
            setTimeout(() => {
                targetQuestion.classList.remove('slide-in-right', 'slide-in-left');
            }, 300);
        }, 300);

        currentQuestionIndex = targetIndex;
        updateProgress();
        updateNavigation();
    }

    function updateProgress() {
        const progress = ((currentQuestionIndex + 1) / totalQuestions) * 100;
        progressBar.style.width = `${progress}%`;
        currentQuestionSpan.textContent = currentQuestionIndex + 1;
    }

    function updateNavigation() {
        questionNavBtns.forEach((btn, index) => {
            btn.classList.remove('border-blue-500', 'bg-blue-500', 'text-white');
            if (index === currentQuestionIndex) {
                btn.classList.add('border-blue-500', 'bg-blue-500', 'text-white');
            } else {
                btn.classList.add('border-gray-300', 'text-gray-700');
            }
        });

        // Update prev/next button visibility
        document.querySelectorAll('.prev-btn').forEach(btn => {
            btn.classList.toggle('invisible', currentQuestionIndex === 0);
        });
    }

    @if($quiz->time_limit)
    function initializeTimer() {
        const timerElement = document.getElementById('timer');
        const timeLimit = parseInt(timerElement.dataset.timeLimit);
        let timeRemaining = timeLimit;

        function updateTimer() {
            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;
            timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            // Color changes for urgency
            if (timeRemaining <= 300) { // 5 minutes
                timerElement.classList.add('text-red-600');
            } else if (timeRemaining <= 600) { // 10 minutes
                timerElement.classList.add('text-orange-600');
            }

            if (timeRemaining <= 0) {
                clearInterval(timerInterval);
                alert('Time is up! Submitting your quiz...');
                quizForm.submit();
            }

            timeRemaining--;
        }

        updateTimer();
        timerInterval = setInterval(updateTimer, 1000);
    }
    @endif

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowRight' && currentQuestionIndex < totalQuestions - 1) {
            navigateToQuestion(currentQuestionIndex + 1);
        } else if (e.key === 'ArrowLeft' && currentQuestionIndex > 0) {
            navigateToQuestion(currentQuestionIndex - 1);
        }
    });

    // Prevent accidental refresh
    window.addEventListener('beforeunload', function(e) {
        e.preventDefault();
        e.returnValue = '';
    });
});
</script>
@endsection