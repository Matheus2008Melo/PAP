@extends('layouts.app')

@section('content')
<div>
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-r from-blue-600 to-purple-700">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
            <div class="text-center max-w-4xl mx-auto">
                <div class="mb-2">
                    <span class="inline-block py-1 px-3 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-100 text-sm font-semibold tracking-wide uppercase backdrop-blur-sm">
                        De Alunos para Alunos
                    </span>
                </div>
                <h1 class="text-5xl md:text-7xl lg:text-8xl font-extrabold text-white tracking-tight mb-4 drop-shadow-md">
                    WeAreSchool
                </h1>
                <p class="text-2xl md:text-3xl text-blue-100 font-light mb-8 leading-tight">
                    O Portfólio da Nossa Escola
                </p>
                <p class="text-lg text-white/80 mb-10 max-w-2xl mx-auto leading-relaxed">
                    Descobre os projetos inovadores, a criatividade e o talento dos nossos alunos em todas as disciplinas.
                    Uma montra digital para o sucesso escolar.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('disciplines.index') }}" class="group relative px-8 py-4 bg-white text-blue-600 rounded-full font-bold text-lg shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                        <span class="relative z-10 flex items-center">
                            Explorar Projetos
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </span>
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



    <!-- Disciplines Section -->
    <section id="disciplinas" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Explorar por Disciplina</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Navegue pelos projetos organizados por áreas de conhecimento. Encontre inspiração na sua área de estudo.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($disciplinas as $disciplina)
                    <a href="{{ route('discipline.show', $disciplina->slug) }}" 
                       class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-shadow">
                        <div class="p-6 border-b border-gray-100" style="border-left-color: {{ $disciplina->cor }}; border-left-width: 4px;">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 rounded-lg flex items-center justify-center text-white" 
                                         style="background: {{ $disciplina->cor }}">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900">{{ $disciplina->nome }}</h3>
                                        <p class="text-sm text-gray-500">{{ $disciplina->projetos_count }} projetos</p>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-600 text-sm mb-4">{{ $disciplina->descricao }}</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>Última atualização: {{ now()->diffForHumans() }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
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
                <a href="#" class="border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    Ver Todos
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($destaques as $projeto)
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden flex flex-col">
                        <div class="relative h-48 overflow-hidden">
                            @if($projeto->featured_image)
                                <img src="{{ Storage::url($projeto->featured_image) }}" alt="{{ $projeto->titulo }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                                    <span class="text-white text-4xl font-bold opacity-50">{{ substr($projeto->titulo, 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="absolute top-4 right-4">
                                <span class="bg-white/90 text-blue-600 px-3 py-1 rounded-full text-xs font-medium">
                                    Destaque
                                </span>
                            </div>
                        </div>
                        <div class="p-6 flex-grow flex flex-col">
                            <div class="flex items-center mb-3">
                                <img src="{{ $projeto->user->avatarUrl() }}" alt="{{ $projeto->user->name }}" class="w-10 h-10 rounded-full object-cover mr-3 border border-gray-200">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $projeto->user->nomeFormatado() }}</h4>
                                    <p class="text-xs text-gray-500">{{ $projeto->published_at ? $projeto->published_at->diffForHumans() : $projeto->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <h3 class="font-bold text-lg text-gray-900 mb-2 truncate" title="{{ $projeto->titulo }}">
                                <a href="{{ route('project.show', ['disciplineSlug' => $projeto->disciplina->slug, 'projectSlug' => $projeto->slug]) }}" class="hover:text-blue-600 transition-colors">
                                    {{ $projeto->titulo }}
                                </a>
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {{ $projeto->descricao }}
                            </p>
                            <div class="flex flex-wrap gap-2 mb-4 mt-auto">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs">{{ $projeto->disciplina->nome }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm text-gray-500 border-t border-gray-100 pt-4 mt-4">
                                <div class="flex items-center space-x-4">
                                    <span class="flex items-center" title="Comentários">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        {{ $projeto->comments()->count() }}
                                    </span>
                                </div>
                                <span class="flex items-center font-bold text-gray-900" title="Avaliação Média">
                                    <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                    {{ number_format($projeto->rating_average, 1) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-purple-700">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-6">Pronto para partilhar o seu trabalho?</h2>
            <p class="text-xl text-blue-100 mb-8">
                Junte-se a centenas de estudantes e professores que já estão a partilhar os seus projetos inspiradores.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('submit-project') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 rounded-lg font-semibold text-lg transition-colors">
                    Submeter Meu Projeto
                </a>
                <a href="#disciplinas" class="border-2 border-white text-white hover:bg-white/10 px-8 py-4 rounded-lg font-semibold text-lg transition-colors">
                    Explorar Primeiro
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
