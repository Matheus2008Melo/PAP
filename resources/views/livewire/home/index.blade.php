@extends('layouts.app')

@section('title', 'WeAreSchool - Portfólio Digital da Escola')

@section('content')
<div>
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-primary-50 via-white to-secondary-50 py-20 md:py-28">
        <!-- Background pattern -->
        <div class="absolute inset-0 bg-grid-gray-900/[0.02] bg-[size:20px_20px]"></div>
        
        <div class="container relative mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <!-- Badge -->
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/80 backdrop-blur-sm border border-primary-200 shadow-sm mb-6">
                    <span class="text-primary-600 font-semibold text-sm">
                        <i class="fas fa-graduation-cap mr-2"></i>Portfólio Digital Escolar
                    </span>
                </div>
                
                <!-- Title -->
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                    Descobre <span class="text-gradient">Talentos</span><br>
                    da Nossa <span class="text-secondary-600">Escola</span>
                </h1>
                
                <!-- Description -->
                <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
                    Uma plataforma onde a criatividade encontra visibilidade. Explora projetos incríveis, partilha o teu trabalho e inspira a comunidade escolar.
                </p>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('portfolio.index') }}" 
                       class="group inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-gradient-to-r from-primary-600 to-secondary-600 rounded-xl hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        Explorar Projetos
                        <i class="fas fa-arrow-right ml-3 group-hover:translate-x-2 transition-transform"></i>
                    </a>
                    <a href="{{ route('projetos.create') }}" 
                       class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-primary-600 border-2 border-primary-200 rounded-xl hover:bg-primary-50 transition-colors">
                        <i class="fas fa-plus mr-3"></i>
                        Partilhar Projeto
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <!-- Projetos Card -->
                <div class="bg-gradient-to-br from-primary-50 to-white p-6 rounded-2xl border border-gray-100 shadow-sm hover-lift">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-xl bg-primary-100 flex items-center justify-center mr-4">
                            <i class="fas fa-project-diagram text-primary-600 text-xl"></i>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-primary-600">{{ $stats['projetos'] }}</div>
                            <div class="text-gray-600 text-sm">Projetos Ativos</div>
                        </div>
                    </div>
                </div>
                
                <!-- Disciplinas Card -->
                <div class="bg-gradient-to-br from-secondary-50 to-white p-6 rounded-2xl border border-gray-100 shadow-sm hover-lift">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-xl bg-secondary-100 flex items-center justify-center mr-4">
                            <i class="fas fa-book-open text-secondary-600 text-xl"></i>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-secondary-600">{{ $stats['disciplinas'] }}</div>
                            <div class="text-gray-600 text-sm">Disciplinas</div>
                        </div>
                    </div>
                </div>
                
                <!-- Alunos Card -->
                <div class="bg-gradient-to-br from-purple-50 to-white p-6 rounded-2xl border border-gray-100 shadow-sm hover-lift">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center mr-4">
                            <i class="fas fa-users text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-purple-600">{{ $stats['autores'] }}</div>
                            <div class="text-gray-600 text-sm">Alunos Ativos</div>
                        </div>
                    </div>
                </div>
                
                <!-- Comentários Card -->
                <div class="bg-gradient-to-br from-green-50 to-white p-6 rounded-2xl border border-gray-100 shadow-sm hover-lift">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center mr-4">
                            <i class="fas fa-comments text-green-600 text-xl"></i>
                        </div>
                        <div>
                            @php
                                $totalComments = \App\Models\Comment::count();
                            @endphp
                            <div class="text-3xl font-bold text-green-600">{{ $totalComments }}</div>
                            <div class="text-gray-600 text-sm">Comentários</div>
                        </div>
                    </div>
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
                    <select wire:model.live="selectedAnoLetivo" 
                            class="form-input border-none bg-transparent py-1 focus:ring-0">
                        <option value="">Todos os anos</option>
                        @foreach($availableAnosLetivos as $ano)
                            <option value="{{ $ano }}">{{ $ano }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if($disciplinas->isEmpty())
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhuma disciplina encontrada</h3>
                    <p class="text-gray-500">Ainda não existem disciplinas disponíveis.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($disciplinas as $disciplina)
                        <a href="{{ route('discipline.show', $disciplina->slug) }}" wire:navigate
                           class="card group animate-slide-up" 
                           style="--delay: {{ $loop->index * 100 }}ms">
                            <div class="card-header" style="border-left-color: {{ $disciplina->cor }}; border-left-width: 4px;">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 rounded-lg flex items-center justify-center text-white" 
                                             style="background: {{ $disciplina->cor }}">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-gray-900 group-hover:text-primary-600 transition-colors">
                                                {{ $disciplina->nome }}
                                            </h3>
                                            <p class="text-sm text-gray-500">
                                                {{ $disciplina->projetos_count }} projetos
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
                                <p class="text-gray-600 text-sm mb-4">{{ $disciplina->descricao }}</p>
                                
                                @if($disciplina->projetos_count > 0)
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>Última atualização: {{ $disciplina->updated_at->diffForHumans() }}</span>
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
    @if($featuredProjetos->count() > 0)
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                        Projetos em <span class="text-secondary-600">Destaque</span>
                    </h2>
                    <p class="text-gray-600 mt-2">Trabalhos excecionais selecionados pela comunidade</p>
                </div>
                <a href="{{ route('portfolio.index') }}" wire:navigate
                   class="inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold">
                    Ver todos os projetos <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredProjetos as $projeto)
                <div class="group bg-white rounded-2xl overflow-hidden border border-gray-200 hover:border-primary-300 hover:shadow-xl transition-all duration-300 hover-lift">
                    <!-- Project Image -->
                    <div class="relative h-56 overflow-hidden bg-gradient-to-br from-gray-100 to-gray-50">
                        @if($projeto->featured_image)
                        <img src="{{ Storage::url($projeto->featured_image) }}" 
                             alt="{{ $projeto->titulo }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="{{ $projeto->disciplina->icone }} text-5xl opacity-30" 
                               style="color: {{ $projeto->disciplina->cor }};"></i>
                        </div>
                        @endif
                        
                        <!-- Badges -->
                        <div class="absolute top-4 left-4 flex flex-col gap-2">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold text-white shadow-md"
                                  style="background-color: {{ $projeto->disciplina->cor }};">
                                {{ $projeto->disciplina->abreviatura }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-sm font-semibold bg-yellow-500 text-white">
                                <i class="fas fa-star mr-1"></i> Destaque
                            </span>
                        </div>
                    </div>
                    
                    <!-- Project Content -->
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm text-gray-500">
                                {{ $projeto->created_at->format('d M, Y') }}
                            </span>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-heart text-red-400 mr-2"></i>
                                <span class="font-medium">{{ $projeto->vote_score }}</span>
                            </div>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary-600 transition-colors">
                            <a href="{{ route('portfolio.projeto', $projeto->slug) }}" wire:navigate>{{ $projeto->titulo }}</a>
                        </h3>
                        
                        <p class="text-gray-600 mb-5 line-clamp-2">
                            {{ $projeto->descricao_curta ?: Str::limit($projeto->descricao, 120) }}
                        </p>
                        
                        <!-- Author -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-primary-500 to-secondary-500 flex items-center justify-center text-white font-semibold text-sm mr-3">
                                    {{ substr($projeto->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-gray-700 font-medium">{{ $projeto->user->name }}</div>
                                    @if($projeto->user->curso)
                                    <div class="text-xs text-gray-500">{{ $projeto->user->curso }}</div>
                                    @endif
                                </div>
                            </div>
                            
                            <a href="{{ route('portfolio.projeto', $projeto->slug) }}" 
                               class="text-primary-600 hover:text-primary-700 font-semibold text-sm flex items-center">
                                Ver detalhes <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Recent Projects -->
    @if($recentProjetos->count() > 0)
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Projetos <span class="text-primary-600">Recentes</span>
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Descobre os trabalhos mais recentes partilhados pela comunidade
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($recentProjetos as $projeto)
                <div class="bg-white rounded-xl p-5 border border-gray-200 hover:border-primary-300 hover:shadow-lg transition-all duration-300 hover-lift">
                    <div class="flex items-start justify-between mb-3">
                        <span class="px-2 py-1 rounded text-xs font-medium" 
                              style="background-color: {{ $projeto->disciplina->cor }}20; color: {{ $projeto->disciplina->cor }};">
                            {{ $projeto->disciplina->abreviatura }}
                        </span>
                        <span class="text-xs text-gray-500">{{ $projeto->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <h3 class="font-bold text-gray-900 mb-2 line-clamp-2">
                        <a href="{{ route('portfolio.projeto', $projeto->slug) }}" class="hover:text-primary-600">
                            {{ $projeto->titulo }}
                        </a>
                    </h3>
                    
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                        {{ $projeto->descricao_curta ?: Str::limit($projeto->descricao, 80) }}
                    </p>
                    
                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <span class="text-sm text-gray-500">por {{ $projeto->user->name }}</span>
                        <a href="{{ route('portfolio.projeto', $projeto->slug) }}" 
                           class="text-primary-600 text-sm hover:text-primary-700 font-medium">
                            Ver <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-10">
                <a href="{{ route('portfolio.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-500 to-secondary-500 text-white rounded-lg font-semibold hover:shadow-lg transition-shadow">
                    Explorar Todos os Projetos
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Final -->
    <section class="py-20 bg-gradient-to-r from-primary-600 to-secondary-600">
        <div class="container mx-auto px-4 text-center">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                    Pronto para mostrar o teu trabalho?
                </h2>
                <p class="text-xl text-primary-100 mb-10">
                    Junta-te a {{ $stats['autores'] }} alunos que já partilharam os seus projetos
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('projetos.create') }}" 
                       class="inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-primary-600 bg-white rounded-xl hover:shadow-2xl transition-all duration-300 hover-lift">
                        <i class="fas fa-rocket mr-3"></i>
                        Criar Meu Projeto
                    </a>
                    <a href="{{ route('portfolio.index') }}" 
                       class="inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-white border-2 border-white/30 rounded-xl hover:bg-white/10 transition-colors">
                        <i class="fas fa-search mr-3"></i>
                        Explorar Projetos
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .line-clamp-1 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
    }
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .line-clamp-3 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }
    .bg-grid-gray-900\/\[0\.02\] {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='rgb(15 23 42 / 0.02)'%3e%3cpath d='M0 .5H31.5V32'/%3e%3c/svg%3e");
    }
</style>
@endsection