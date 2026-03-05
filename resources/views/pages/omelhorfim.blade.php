@extends('layouts.app')

@section('content')
    <div class="relative h-screen w-full flex flex-col items-center justify-start pt-20 bg-white text-gray-800">

        <!-- Título final -->
        <h1
            class="text-5xl font-extrabold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 drop-shadow-sm">
            O Melhor Fim do Mundo
        </h1>

        <!-- GIF em destaque -->
        <img src="{{ asset('gifs/fim.gif') }}" alt="O Melhor Fim do Mundo"
            class="max-w-[600px] max-h-[400px] object-contain z-10 drop-shadow-xl rounded-2xl border border-gray-200">

        <!-- Subtítulo final -->
        <p class="mt-8 text-lg text-gray-600 italic">
            Obrigado pela atenção :)
        </p>
    </div>
@endsection
