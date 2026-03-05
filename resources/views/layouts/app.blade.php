<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'WeAreSchool')) - Plataforma de Projetos Escolares</title>
    <meta name="description" content="WeAreSchool - Descubra e compartilhe projetos escolares incríveis de diversas disciplinas.">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|poppins:400,500,600,700" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire Styles -->
    @livewireStyles

    <!-- Highlight.js Syntax Highlighter Theme -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Additional Styles -->
    @stack('styles')
</head>
<body class="font-sans antialiased gradient-bg min-h-screen flex flex-col {{ request()->is('chat*') ? 'bg-gray-50' : '' }}">
    <!-- Navigation -->
    <nav x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 bg-white/90 backdrop-blur-sm border-b border-gray-100 shadow-sm">
        <div class="{{ request()->is('chat*') ? 'w-full' : 'max-w-7xl' }} mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex lg:flex-1 items-center justify-start">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <x-app-logo class="h-12 w-12 text-blue-600" />
                    </a>
                </div>

                <!-- Desktop Navigation (Centered) -->
                <div class="hidden lg:flex lg:items-center lg:justify-center lg:space-x-8">
                    <a href="{{ route('home') }}" 
                       class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-blue-600 font-bold' : '' }}">
                        Início
                    </a>
                    
                    <a href="{{ route('disciplines.index') }}" 
                       class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('disciplines.index') ? 'text-blue-600 font-bold' : '' }}">
                        Disciplinas
                    </a>
                    
                    <a href="{{ route('submit-project') }}" 
                       class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('submit-project') ? 'text-blue-600 font-bold' : '' }}">
                        Submeter Projeto
                    </a>
                    
                    @auth
                    <a href="{{ route('chat') }}" wire:navigate
                       class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('chat') ? 'text-blue-600 font-bold' : '' }}">
                        <i class="far fa-comments"></i> Mensagens
                        @php
                            $unreadCount = \App\Models\Message::whereHas('conversation', function($q) {
                                $q->where('sender_id', auth()->id())->orWhere('receiver_id', auth()->id());
                            })->where('user_id', '!=', auth()->id())->whereNull('read_at')->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span class="ml-1 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $unreadCount }}</span>
                        @endif
                    </a>
                    @endauth
                </div>

                <!-- User Menu & Mobile Button -->
                <div class="flex lg:flex-1 items-center justify-end">
                    @auth
                        <!-- Notifications -->
                        <!-- Notifications -->
                        <livewire:notifications />

                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-primary-700 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-medium text-gray-700 hidden lg:inline">{{ auth()->user()->name }}</span>
                                <svg :class="{'transform rotate-180': open}" class="w-4 h-4 text-gray-400 transition-transform" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                                
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                
                                <a href="{{ route('profile') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Meu Perfil
                                </a>
                                
                                <a href="{{ route('my-projects') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Meus Projetos
                                </a>
                                
                                @if(auth()->user()->isAdmin() || auth()->user()->isModerator())
                                <div class="border-t border-gray-100 my-1"></div>
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm text-primary-600 hover:bg-primary-50">
                                    <svg class="w-5 h-5 mr-3" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Painel Admin
                                </a>
                                @endif
                                
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50">
                                        <svg class="w-5 h-5 mr-3" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Terminar Sessão
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Auth Buttons -->
                        <div class="hidden lg:flex items-center space-x-4">
                            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-medium transition-colors text-sm shadow-sm">
                                Entrar
                            </a>
                            <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-medium transition-colors text-sm shadow-sm">
                                Registar
                            </a>
                        </div>
                    @endauth

                    <!-- Mobile menu button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 ml-2 rounded-lg hover:bg-gray-100">
                        <svg class="w-6 h-6 text-gray-600" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" class="lg:hidden border-t border-gray-100 bg-white">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">
                    Início
                </a>
                
                <a href="{{ route('disciplines.index') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">
                    Disciplinas
                </a>
                
                @auth
                <a href="{{ route('chat') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">
                    Mensagens
                </a>
                @endauth
                

                
                @guest
                <div class="px-3 py-2 space-y-2">
                    <a href="{{ route('login') }}" class="block btn-outline text-center">
                        Entrar
                    </a>
                    <a href="{{ route('register') }}" class="block btn-primary text-center">
                        Registar
                    </a>
                </div>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-grow flex flex-col {{ request()->is('chat*') ? 'w-full px-4 py-8' : 'w-full max-w-7xl mx-auto' }}">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    <!-- Footer -->
    @if(!request()->is('chat*'))
    <footer class="bg-gradient-to-b from-white to-gray-50 border-t border-gray-100 mt-16">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center justify-center">
                <!-- Brand -->
                <a href="{{ route('home') }}" class="flex flex-col items-center space-y-3 mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl flex items-center justify-center shadow-md">
                        <svg class="w-10 h-10 text-white" width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <div class="text-center">
                        <span class="text-3xl font-bold text-gray-900">WeAreSchool</span>
                        <p class="text-gray-900 font-medium mt-1">Plataforma de partilha de projetos escolares</p>
                    </div>
                </a>
                <p class="text-gray-900 text-sm mb-8 max-w-2xl mx-auto text-center">
                    Conectamos estudantes e professores através da partilha de conhecimento e projetos inspiradores.
                </p>
                <div class="flex justify-center space-x-6">
                    <a href="#" class="text-gray-900 hover:text-primary-600 transition-colors">
                        <svg class="w-6 h-6" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-900 hover:text-primary-600 transition-colors">
                        <svg class="w-6 h-6" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-900 hover:text-primary-600 transition-colors">
                        <svg class="w-6 h-6" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                    </a>
                </div>
            </div>



            <div class="mt-8 pt-8 border-t border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-900 text-sm">
                        &copy; {{ date('Y') }} WeAreSchool. Todos os direitos reservados.
                    </p>
                    <p class="text-gray-900 text-sm mt-2 md:mt-0">
                        De Alunos para Alunos
                    </p>
                </div>
            </div>
        </div>
    </footer>
    @endif

    <!-- Scripts -->
    @livewireScripts
    
    <!-- Flowbite JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>
    
    <!-- Alpine.js is already included by Livewire v3 -->

    <!-- Custom Scripts -->
    <script>
        // Mobile menu state
        document.addEventListener('alpine:init', () => {
            Alpine.data('mobileMenu', () => ({
                open: false
            }));
        });

        // Smooth scroll to top
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Back to top button
        window.addEventListener('scroll', function() {
            var backToTopButton = document.getElementById('backToTop');
            if (backToTopButton) {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.remove('opacity-0', 'invisible');
                    backToTopButton.classList.add('opacity-100', 'visible');
                } else {
                    backToTopButton.classList.remove('opacity-100', 'visible');
                    backToTopButton.classList.add('opacity-0', 'invisible');
                }
            }
        });

    </script>

    <!-- Back to Top Button -->
    <button id="backToTop" onclick="scrollToTop()" 
            class="fixed bottom-8 right-8 p-3 bg-primary-600 text-white rounded-full shadow-lg hover:bg-primary-700 transition-all duration-300 opacity-0 invisible hover:scale-110 z-40">
        <svg class="w-6 h-6" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>

    <!-- Highlight.js Core -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('pre code').forEach((el) => {
                hljs.highlightElement(el);
            });
        });
    </script>

    @stack('scripts')
</body>
</html>