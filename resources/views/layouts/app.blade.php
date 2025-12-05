<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Language Vocabulary Builder</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .progress-ring {
            transform: rotate(-90deg);
        }
        .progress-ring-circle {
            transition: stroke-dashoffset 0.3s;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-book text-white text-lg"></i>
                                </div>
                                <div>
                                    <h1 class="text-xl font-bold text-gray-900">VocabMaster</h1>
                                    <p class="text-xs text-gray-500">Language Builder</p>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center space-x-1">
                                <i class="fas fa-home text-sm"></i>
                                <span>Dashboard</span>
                            </x-nav-link>
                            <x-nav-link :href="route('words.index')" :active="request()->routeIs('words.index')" class="flex items-center space-x-1">
                                <i class="fas fa-book-open text-sm"></i>
                                <span>Vocabulary</span>
                            </x-nav-link>
                            <x-nav-link :href="route('quizzes.index')" :active="request()->routeIs('quizzes.*')" class="flex items-center space-x-1">
                                <i class="fas fa-tasks text-sm"></i>
                                <span>Quizzes</span>
                            </x-nav-link>
                            <x-nav-link :href="route('favorites.index')" :active="request()->routeIs('favorites.index')" class="flex items-center space-x-1">
                                <i class="fas fa-star text-sm"></i>
                                <span>Favorites</span>
                            </x-nav-link>
                        </div>
                    </div>

                    <!-- Right Navigation -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <div class="ml-3 relative">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                                <span class="text-white text-sm font-semibold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                            </div>
                                            <div class="text-left">
                                                <div class="font-semibold text-gray-900">{{ Auth::user()->name }}</div>
                                                <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                                            </div>
                                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <!-- Admin Link -->
                                    @if(Auth::user()->is_admin)
                                    <x-dropdown-link :href="route('dashboard')" class="flex items-center space-x-2">
                                        <i class="fas fa-cog text-gray-400"></i>
                                        <span>Admin Panel</span>
                                    </x-dropdown-link>
                                    @endif

                                    <!-- User Management -->
                                    <x-dropdown-link :href="route('profile.edit')" class="flex items-center space-x-2">
                                        <i class="fas fa-user text-gray-400"></i>
                                        <span>Profile</span>
                                    </x-dropdown-link>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')" 
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();" 
                                                class="flex items-center space-x-2 text-red-600">
                                            <i class="fas fa-sign-out-alt"></i>
                                            <span>Log Out</span>
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center space-x-2">
                        <i class="fas fa-home w-4"></i>
                        <span>Dashboard</span>
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('words.index')" :active="request()->routeIs('words.index')" class="flex items-center space-x-2">
                        <i class="fas fa-book-open w-4"></i>
                        <span>Vocabulary</span>
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('quizzes.index')" :active="request()->routeIs('quizzes.*')" class="flex items-center space-x-2">
                        <i class="fas fa-tasks w-4"></i>
                        <span>Quizzes</span>
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('favorites.index')" :active="request()->routeIs('favorites.index')" class="flex items-center space-x-2">
                        <i class="fas fa-star w-4"></i>
                        <span>Favorites</span>
                    </x-responsive-nav-link>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        @if(Auth::user()->is_admin)
                        <x-responsive-nav-link :href="route('admin.dashboard')" class="flex items-center space-x-2">
                            <i class="fas fa-cog w-4"></i>
                            <span>Admin Panel</span>
                        </x-responsive-nav-link>
                        @endif

                        <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center space-x-2">
                            <i class="fas fa-user w-4"></i>
                            <span>Profile</span>
                        </x-responsive-nav-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-responsive-nav-link :href="route('logout')" 
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();" 
                                    class="flex items-center space-x-2 text-red-600">
                                <i class="fas fa-sign-out-alt w-4"></i>
                                <span>Log Out</span>
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-16">
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex justify-center md:justify-start">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book text-white text-sm"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">VocabMaster</h2>
                                <p class="text-xs text-gray-500">Build your vocabulary, master languages</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 md:mt-0 flex justify-center space-x-6">
                        <a href="#" class="text-gray-400 hover:text-gray-500">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-500">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-500">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </div>
                </div>
                <div class="mt-8 border-t border-gray-200 pt-8 md:flex md:items-center md:justify-between">
                    <p class="text-center text-sm text-gray-500 md:text-left">
                        &copy; 2024 VocabMaster. All rights reserved.
                    </p>
                    <div class="mt-4 flex justify-center space-x-6 md:mt-0">
                        <a href="#" class="text-sm text-gray-500 hover:text-gray-900">Privacy</a>
                        <a href="#" class="text-sm text-gray-500 hover:text-gray-900">Terms</a>
                        <a href="#" class="text-sm text-gray-500 hover:text-gray-900">Contact</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Progress ring animation
        function updateProgressRing(ring, percentage) {
            const circle = ring.querySelector('.progress-ring-circle');
            const radius = circle.r.baseVal.value;
            const circumference = radius * 2 * Math.PI;
            
            circle.style.strokeDasharray = `${circumference} ${circumference}`;
            circle.style.strokeDashoffset = circumference - (percentage / 100) * circumference;
        }

        // Initialize progress rings on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.progress-ring').forEach(ring => {
                const percentage = ring.getAttribute('data-percentage');
                updateProgressRing(ring, percentage);
            });
        });
    </script>
</body>
</html>