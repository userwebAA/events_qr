<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Events Five - Administration</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @yield('styles')
    <style>
        .nav-shadow {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: box-shadow 0.3s ease;
        }
        
        .nav-shadow:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .logo-hover {
            transition: transform 0.3s ease;
        }
        
        .logo-hover:hover {
            transform: scale(1.05);
        }

        .logout-button {
            transition: all 0.3s ease;
        }
        
        .logout-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(220, 38, 38, 0.2);
        }

        /* Animation d'entrée pour la navbar */
        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-slide-down {
            animation: slideDown 0.5s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white nav-shadow animate-slide-down shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                            <img src="{{ asset('images/Black and Red Bold Prime Rib Steak Product Features Instagram Post.svg') }}"
                                 alt="Events Five Logo"
                                 class="h-12 w-auto logo-hover">
                        </a>
                    </div>
                    <!-- Navigation Links -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg mx-2">
                            <span class="material-icons mr-3">dashboard</span>
                            Tableau de bord
                        </a>
                        <a href="{{ route('admin.questions.index') }}" 
                           class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg mx-2">
                            <span class="material-icons mr-3">quiz</span>
                            Questions
                        </a>
                        <a href="{{ route('admin.statistics.index') }}" 
                           class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg mx-2">
                            <span class="material-icons mr-3">analytics</span>
                            Statistiques
                        </a>
                    </div>
                </div>
                <!-- Bouton déconnexion -->
                <div class="flex items-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="logout-button inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
