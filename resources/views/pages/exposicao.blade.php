@extends('layouts.app')

@section('title', 'Exposição e Organização dos Veículos')

@section('content')
    <div class="flex justify-center items-start min-h-screen p-6 bg-gray-50">
        <div class="bg-white shadow rounded-2xl p-6 max-w-3xl w-full">
            <h1 class="text-3xl font-bold text-blue-600 mb-4 text-center">Exposição e Organização dos Veículos</h1>

            <p class="mb-4 text-gray-700 leading-relaxed">Os automóveis estão distribuídos de forma estratégica:</p>

            <ul class="list-disc pl-6 space-y-2 text-gray-700 leading-relaxed">
                <li><strong>Exposição interior:</strong> modelos de destaque, lançamentos e viaturas premium.</li>
                <li><strong>Exposição exterior:</strong> maior variedade, normalmente carros usados e seminovos.</li>
            </ul>

            <p class="mt-4 text-gray-700 leading-relaxed">
                Cada veículo possui uma ficha técnica com informações como consumo, potência, ano, quilometragem, preço,
                matrícula e condições de pagamento.
            </p>
        </div>
    </div>
@endsection
