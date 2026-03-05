@extends('layouts.app')

@section('title', 'Casos de Uso')

@section('content')
    <div class="flex justify-center items-start min-h-screen p-6 bg-gray-50">
        <div class="bg-white shadow rounded-2xl p-6 max-w-3xl w-full text-center">
            <h1 class="text-3xl font-bold text-blue-600 mb-6">Casos de Uso</h1>

            {{-- Imagem de exemplo --}}
            <div class="max-w-3xl mx-auto">
                <img src="{{ asset('imagens/casos.png') }}" alt="Exemplo de caso de uso"
                    class="rounded-2xl shadow-lg mx-auto transition-transform duration-300 hover:scale-105">
            </div>

            {{-- Texto explicativo --}}

        </div>
    </div>
@endsection
