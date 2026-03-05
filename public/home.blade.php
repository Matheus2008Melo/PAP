<div>
    <!-- Hero Section -->
    <section class="relative overflow-hidden hero-gradient">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 animate-fade-in">
                    Descubra Projetos Escolares 
                    <span class="block text-primary-200">Inspiradores</span>
                </h1>
                <p class="text-xl text-white/90 mb-8 max-w-3xl mx-auto animate-fade-in animation-delay-200">
                    Explore, compartilhe e inspire-se com projetos de estudantes de diversas disciplinas. 
                    Uma plataforma dedicada ao conhecimento e criatividade escolar.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in animation-delay-400">
                    @auth
                        <a href="{{ route('submit-project') }}" class="btn-primary bg-white text-primary-600 hover:bg-gray-100 text-lg px-8 py-4">
                            <svg class="w-6 h-6 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Submeter Meu Projeto
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary bg-white text-primary-600 hover:bg-gray-100 text-lg px-8 py-4">
                            Começar Agora
                        </a>
                    @endauth
                    <a href="#disciplinas" class="btn-outline border-white text-white hover:bg-white/10 text-lg px-8 py-4">
                        Explorar Projetos
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Wave Divider -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg class="w-full h-auto" viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 100C120 80 240 40 360 30C480 20 600 40 720 50C840 60 960 60 1080 45C1200 30 1320 0 1380 0H1440V120H0Z" fill="white"/>
            </svg>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-4xl font-bold text-primary-600 mb-2">{{ $totalProjects ?? 0 }}</div>
                    <div class="text-gray-600 font-medium">Projetos Publicados</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-primary-600 mb-2">{{ $totalUsers ?? 0 }}</div>
                    <div class="text-gray-600 font-medium">Estudantes Ativos</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-primary-600 mb-2">{{ $totalDisciplines ?? 0 }}</div>
                    <div class="text-gray-600 font-medium">Disciplinas</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-primary-600 mb-2">{{ $totalComments ?? 0 }}</div>
                    <div class="text-gray-600 font-medium">Comentários</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Disciplines Section -->
    <section id="disciplinas" class="py-16 bg-gradient-to-b from-white to-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Explorar por Disciplina</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Navegue pelos projetos organizados por áreas de conhecimento. Encontre inspiração na sua área de estudo.
                </p>
                
                <!-- Year Filter -->
                <div class="mt-8 inline-flex items-center space-x-4 bg-white rounded-lg border border-gray-200 p-2">
                    <span class="text-gray-700 font-medium">Filtrar por ano:</span>
                    <select wire:model="selectedYear" 
                            class="form-input border-none bg-transparent py-1 focus:ring-0">
                        <option value="">Todos os anos</option>
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if($disciplines->isEmpty())
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhuma disciplina encontrada</h3>
                    <p class="text-gray-500">Ainda não existem disciplinas disponíveis.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($disciplines as $discipline)
                        <a href="{{ route('discipline.show', $discipline->slug) }}" 
                           class="card group animate-slide-up" 
                           style="--delay: {{ $loop->index * 100 }}ms">
                            <div class="card-header" style="border-left-color: {{ $discipline->color }}; border-left-width: 4px;">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 rounded-lg flex items-center justify-center text-white" 
                                             style="background: {{ $discipline->color }}">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-gray-900 group-hover:text-primary-600 transition-colors">
                                                {{ $discipline->name }}
                                            </h3>
                                            <p class="text-sm text-gray-500">
                                                {{ $discipline->active_projects_count }} projetos
                                            </p>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-600 transform group-hover:translate-x-1 transition-all" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="text-gray-600 text-sm mb-4">{{ $discipline->description }}</p>
                                
                                @if($discipline->active_projects_count > 0)
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>Última atualização: {{ $discipline->updated_at->diffForHumans() }}</span>
                                    </div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Featured Projects -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Projetos em Destaque</h2>
                    <p class="text-gray-600">Os projetos mais populares e bem avaliados da comunidade</p>
                </div>
                <a href="#" class="btn-outline text-sm">
                    Ver Todos
                    <svg class="w-4 h-4 ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Featured Project Card -->
                <div class="card group">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                             alt="Projeto em destaque" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute top-4 right-4">
                            <span class="badge badge-primary bg-white/90 text-primary-600 backdrop-blur-sm">
                                Popular
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center text-white font-bold mr-3">
                                JS
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">João Silva</h4>
                                <p class="text-xs text-gray-500">3 dias atrás</p>
                            </div>
                        </div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2 group-hover:text-primary-600 transition-colors">
                            Sistema de Gestão Escolar
                        </h3>
                        <p class="text-gray-600 text-sm mb-4">
                            Sistema completo desenvolvido em Laravel para gestão de escolas, com módulos de alunos, professores e notas.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="badge badge-primary">Laravel</span>
                            <span class="badge badge-primary">MySQL</span>
                            <span class="badge badge-primary">Tailwind</span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <div class="flex items-center space-x-4">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                    42
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    15
                                </span>
                            </div>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                4.8
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Add more featured projects similarly -->
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-primary-600 to-primary-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-6">Pronto para partilhar o seu trabalho?</h2>
            <p class="text-xl text-primary-100 mb-8">
                Junte-se a centenas de estudantes e professores que já estão a partilhar os seus projetos inspiradores.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('submit-project') }}" class="btn-primary bg-white text-primary-600 hover:bg-gray-100 text-lg px-8 py-4">
                        Submeter Meu Projeto
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary bg-white text-primary-600 hover:bg-gray-100 text-lg px-8 py-4">
                        Criar Conta Grátis
                    </a>
                @endauth
                <a href="#disciplinas" class="btn-outline border-white text-white hover:bg-white/10 text-lg px-8 py-4">
                    Explorar Primeiro
                </a>
            </div>
        </div>
    </section>
</div>

<style>
    .animation-delay-200 {
        animation-delay: 200ms;
    }
    .animation-delay-400 {
        animation-delay: 400ms;
    }
    .animate-slide-up {
        animation: slideUp 0.5s ease-out;
        animation-delay: calc(var(--delay, 0) * 1ms);
        animation-fill-mode: both;
    }
</style>