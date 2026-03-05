@extends('layouts.app')

@section('title', $disciplina->nome . ' - WeAreSchool')

@section('content')
<div>
    <!-- Hero da Disciplina -->
    <div class="py-12" style="background: linear-gradient(135deg, {{ $disciplina->cor }}10, white);">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="md:w-2/3">
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mb-4" 
                         style="background-color: {{ $disciplina->cor }}20; color: {{ $disciplina->cor }};">
                        <i class="{{ $disciplina->icone }} mr-2"></i>
                        {{ $disciplina->nome }}
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $disciplina->nome }}</h1>
                    <p class="text-gray-600 text-lg mb-6">{{ $disciplina->descricao }}</p>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">
                            <span class="font-bold">{{ $projetos->total() }}</span> projetos publicados
                        </span>
                        <span class="text-gray-500">•</span>
                        <a href="{{ route('portfolio.index') }}" wire:navigate class="text-primary-600 hover:text-primary-800 font-medium">
                            Ver todas as disciplinas
                        </a>
                    </div>
                </div>
                <div class="md:w-1/3 flex justify-center mt-8 md:mt-0">
                    <div class="w-48 h-48 rounded-2xl flex items-center justify-center shadow-lg" 
                         style="background-color: {{ $disciplina->cor }}20;">
                        <i class="{{ $disciplina->icone }} text-6xl" style="color: {{ $disciplina->cor }};"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtro por Ano -->
    @if($tags->count() > 0)
    <div class="container mx-auto px-4 my-8">
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('portfolio.disciplina', $disciplina->slug) }}" wire:navigate
                   class="px-4 py-2 rounded-lg border {{ !$tagFilter ? 'bg-primary-600 text-white border-primary-600' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Todos os Anos
                </a>
                @foreach($tags as $tag)
                <a href="?tag={{ $tag->id }}" 
                   wire:click="$set('tagFilter', {{ $tag->id }})" 
                   class="px-4 py-2 rounded-lg border {{ $tagFilter == $tag->id ? 'bg-primary-600 text-white border-primary-600' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ $tag->nome }}
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Projetos da Disciplina -->
    <div class="container mx-auto px-4 mb-12">
        @if($projetos->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($projetos as $projeto)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 hover:shadow-xl transition-all duration-300 hover-lift">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-primary-600 transition-colors">
                        <a href="{{ route('portfolio.projeto', $projeto->slug) }}" wire:navigate>{{ $projeto->titulo }}</a>
                    </h3>
                    
                    <p class="text-gray-600 mb-4 line-clamp-2">
                        {{ $projeto->descricao_curta ?: Str::limit($projeto->descricao, 150) }}
                    </p>
                    
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-primary-500 to-secondary-500 flex items-center justify-center text-white font-semibold text-sm mr-3">
                                {{ substr($projeto->user->name, 0, 1) }}
                            </div>
                            <span class="text-gray-700">{{ $projeto->user->name }}</span>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-500">{{ $projeto->created_at->format('M Y') }}</span>
                            @if($projeto->tags->count() > 0)
                            @php $tag = $projeto->tags->first(); @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium" 
                                  style="background-color: {{ $tag->cor }}20; color: {{ $tag->cor }};">
                                {{ $tag->nome }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $projetos->links() }}
        </div>

        @else
        <!-- Empty State -->
        <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                <i class="{{ $disciplina->icone }} text-2xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-900 mb-2">Ainda sem projetos nesta disciplina</h3>
            <p class="text-gray-600 mb-6">Sê o primeiro a partilhar um projeto de {{ $disciplina->nome }}!</p>
            @auth
            <a href="{{ route('projetos.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-secondary-600 text-white rounded-lg font-semibold hover:shadow-lg transition">
                <i class="fas fa-plus mr-2"></i>
                Criar Projeto
            </a>
            @else
            <a href="{{ route('login') }}" 
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-secondary-600 text-white rounded-lg font-semibold hover:shadow-lg transition">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Entrar para partilhar
            </a>
            @endauth
        </div>
        @endif
    </div>
</div>

<style>
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