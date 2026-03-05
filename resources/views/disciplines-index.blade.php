@extends('layouts.app')

@section('title', 'Todas as Disciplinas - WeAreSchool')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
                Disciplinas
            </h1>
            <p class="mt-5 max-w-xl mx-auto text-xl text-gray-500">
                Explora projetos por área de estudo. Escolhe uma disciplina para veres os trabalhos mais recentes.
            </p>
        </div>

        @if(isset($disciplinas) && $disciplinas->isNotEmpty())
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($disciplinas as $disciplina)
                    <a href="{{ route('discipline.show', $disciplina->slug) }}" class="group relative bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col h-full transform hover:-translate-y-1">
                        <div class="h-2 w-full" style="background-color: {{ $disciplina->cor }}"></div>
                        <div class="p-6 flex-1 flex flex-col items-center text-center">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white text-2xl mb-4 shadow-lg transform group-hover:scale-110 transition-transform duration-300" style="background-color: {{ $disciplina->cor }}">
                                <i class="fas {{ $disciplina->icone }}"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                {{ $disciplina->nome }}
                            </h3>
                            <p class="mt-2 text-sm text-gray-500 line-clamp-2">
                                {{ $disciplina->description ?? 'Explora os projetos de ' . $disciplina->nome }}
                            </p>
                        </div>
                        <div class="bg-gray-50 px-6 py-3 border-t border-gray-100 flex justify-between items-center text-xs text-gray-500">
                            <span>Ver projetos</span>
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform text-gray-400 group-hover:text-blue-500"></i>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-folder-open text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900">Nenhuma disciplina encontrada</h3>
                <p class="mt-2 text-gray-500">Tenta novamente mais tarde.</p>
            </div>
        @endif
    </div>
</div>
@endsection
