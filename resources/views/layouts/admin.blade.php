<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Painel Admin - WeAreSchool')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 font-sans">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="bg-gray-900 text-white w-64 space-y-6 py-7 px-2 fixed inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition duration-200 ease-in-out">
            <!-- Logo -->
            <div class="text-white flex items-center space-x-2 px-4">
                <div class="w-8 h-8 rounded-lg bg-blue-500 flex items-center justify-center">
                    <i class="fas fa-cog"></i>
                </div>
                <span class="text-xl font-bold">WeAreSchool</span>
            </div>

            <!-- Navigation -->
            <nav>
                <a href="{{ route('dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </a>
                <a href="{{ route('disciplinas.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white">
                    <i class="fas fa-book mr-2"></i>Disciplinas
                </a>
                <a href="{{ route('projetos.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white">
                    <i class="fas fa-project-diagram mr-2"></i>Projetos
                </a>
                <a href="{{ route('tags.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white">
                    <i class="fas fa-tags mr-2"></i>Tags
                </a>
                <a href="{{ route('users.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white">
                    <i class="fas fa-users mr-2"></i>Utilizadores
                </a>
                <div class="border-t border-gray-700 my-4"></div>
                <a href="{{ route('home') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-800">
                    <i class="fas fa-home mr-2"></i>Voltar ao Site
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 md:ml-64">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                        <p class="text-gray-600">@yield('page-description', 'Painel de Administração')</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button @click="dropdownOpen = !dropdownOpen" class="flex items-center">
                                @if(auth()->user()->avatar)
                                <img src="{{ Storage::url(auth()->user()->avatar) }}" 
                                     class="w-8 h-8 rounded-full">
                                @else
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                @endif
                                <span class="ml-2">{{ auth()->user()->name }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="p-6">
                <!-- Flash Messages -->
                @if(session()->has('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
    <script>
        // Scripts específicos do admin
    </script>
</body>
</html>