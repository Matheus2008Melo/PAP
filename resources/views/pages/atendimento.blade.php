@extends('layouts.app')

@section('title', 'Atendimento ao Cliente')

@section('content')
    <div class="flex justify-center items-start min-h-screen p-6 bg-gray-50">
        <div class="bg-white shadow rounded-2xl p-6 max-w-3xl w-full">
            <h1 class="text-3xl font-bold text-blue-600 mb-4 text-center">Atendimento ao Cliente</h1>

            <p class="mb-4 text-gray-700 leading-relaxed">
                O stand conta com empregados razoavelmente bons, que têm como função ouvir as necessidades do cliente e
                propor
                o carro mais adequado.
            </p>

            <ul class="list-disc pl-6 space-y-2 text-gray-700 leading-relaxed">
                <li>Explicação das características técnicas.</li>
                <li>Comparação entre diferentes modelos.</li>
                <li>Orientação sobre consumo, segurança, tecnologia e manutenção.</li>
            </ul>

            <p class="mt-4 text-gray-700 leading-relaxed">
                Há também apoio digital, com tablets, catálogos online e simuladores de preços e prestações.
            </p>
        </div>
    </div>
@endsection
