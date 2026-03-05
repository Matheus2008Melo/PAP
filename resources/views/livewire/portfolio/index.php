@extends('layouts.app')

@section('title', 'Portfólio - WeAreSchool')

@section('content')
<div>
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary-50 to-secondary-50 py-12 mb-10">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Portfólio WeAreSchool</h1>
            <p class="text-gray-600 text-lg">Descobre projetos incríveis de todas as disciplinas</p>
        </div>
    </div>

    <!-- Filtros -->
    <div class="container mx-auto px-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" wire:model.live.debounce.300ms="search" 
                               placeholder="Pesquisar projetos..." 
                               class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition">
                    </div>
                </div>

                <!-- Disciplina Filter -->
                <div>
                    <select wire:model.live="disciplinaFilter" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition bg-white">
                        <option value="">Todas as Disciplinas</option>
                        @foreach($disciplinas as $disciplina)
                            <option value="{{ $disciplina->id }}">{{ $disciplina->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tag Filter -->
                <div>
                    <select wire:model.live="tagFilter" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition bg-white">
                        <option value="">Todos os Anos</option>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <select wire:model.live="sortBy" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition bg-white">
                        <option value="recent">Mais Recentes</option>
                        <option value="popular">Mais Populares</option>
                        <option value="oldest">Mais Antigos</option>
                    </select>
                </div>
            </div>
            
            <!-- Results Count -->
            <div class="flex justify-between items-center mt-6 pt-6 border-t border-gray-100">
                <div class="text-gray-600">
                    <span class="font-semibold">{{ $projetos->total() }}</span> projetos encontrados
                </div>
                <div class="text-sm text-gray-500">
                    Mostrando {{ $projetos->firstItem() ?? 0 }}-{{ $projetos->lastItem() ?? 0 }} de {{ $projetos->total() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Grid de Projetos -->
    <div class="container mx-auto px-4 mb-16">
        @if($projetos->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($projetos as $projeto)
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-200 hover:border-primary-300 hover:shadow-lg transition-all duration-300 hover-lift">
                <!-- Image/Header -->
                <div class="relative h-56 overflow-hidden bg-gradient-to-br from-gray-100 to-gray-50">
                    @if($projeto->featured_image)
                    <img src="{{ Storage::url($projeto->featured_image) }}" 
                         alt="{{ $projeto->titulo }}" 
                         class="w-full h-full object-cover hover:scale-105 transition duration-500">
                    @else
                    <div class="w-full h-full flex items-center justify-center" 
                         style="background: linear-gradient(135deg, {{ $projeto->disciplina->cor }}20, {{ $projeto->disciplina->cor }}40);">
                        <i class="{{ $projeto->disciplina->icone }} text-5xl opacity-30" 
                           style="color: {{ $projeto->disciplina->cor }};"></i>
                    </div>
                    @endif
                    
                    <!-- Disciplina Badge -->
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold text-white shadow-md" 
                              style="background-color: {{ $projeto->disciplina->cor }};">
                            {{ $projeto->disciplina->abreviatura }}
                        </span>
                    </div>
                    
                    <!-- Votes -->
                    <div class="absolute top-4 right-4">
                        <div class="bg-white/90 backdrop-blur-sm rounded-lg px-3 py-1 shadow flex items-center space-x-1">
                            <i class="fas fa-heart text-red-400 text-sm"></i>
                            <span class="text-sm font-bold text-gray-900">{{ $projeto->vote_score }}</span>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <!-- Tags -->
                    <div class="mb-3 flex flex-wrap gap-1">
                        @foreach($projeto->tags->take(2) as $tag)
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium" 
                              style="background-color: {{ $tag->cor }}20; color: {{ $tag->cor }};">
                            {{ $tag->nome }}
                        </span>
                        @endforeach
                        @if($projeto->tags->count() > 2)
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-600">
                            +{{ $projeto->tags->count() - 2 }}
                        </span>
                        @endif
                    </div>

                    <!-- Title -->
                    <h3 class="text-xl font-bold text-gray-900 mb-2 hover:text-primary-600 transition-colors">
                        <a href="{{ route('portfolio.projeto', $projeto->slug) }}">{{ $projeto->titulo }}</a>
                    </h3>

                    <!-- Short Description -->
                    <p class="text-gray-600 mb-4 line-clamp-2">
                        {{ $projeto->descricao_curta ?: Str::limit($projeto->descricao, 120) }}
                    </p>

                    <!-- Footer -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-primary-500 to-secondary-500 flex items-center justify-center text-white font-semibold text-sm mr-3">
                                {{ substr($projeto->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $projeto->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $projeto->created_at->format('M Y') }}</div>
                            </div>
                        </div>
                        
                        <a href="{{ route('portfolio.projeto', $projeto->slug) }}" 
                           class="text-primary-600 hover:text-primary-700 font-medium text-sm flex items-center">
                            Ver projeto
                            <i class="fas fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Paginação -->
        <div class="mt-12">
            {{ $projetos->links() }}
        </div>

        @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-gray-100 to-gray-50 border border-gray-200 mb-6">
                <i class="fas fa-search text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">Nenhum projeto encontrado</h3>
            <p class="text-gray-600 mb-6 max-w-md mx-auto">Tenta alterar os filtros ou volta mais tarde.</p>
            <button wire:click="$set('search', '')" wire:click="$set('disciplinaFilter', '')" wire:click="$set('tagFilter', '')"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-500 to-secondary-500 text-white rounded-lg font-semibold hover:shadow-lg transition">
                <i class="fas fa-filter mr-2"></i>
                Limpar Filtros
            </button>
        </div>
        @endif
    </div>
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
    .hover-lift:hover {
        transform: translateY(-4px);
        transition: transform 0.3s ease;
    }
</style>
@endsection