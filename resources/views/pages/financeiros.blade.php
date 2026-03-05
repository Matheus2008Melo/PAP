@extends('layouts.app')

@section('title', 'Serviços Financeiros')

@section('content')
    <div class="flex justify-center items-start min-h-screen p-6 bg-gray-50">
        <div class="bg-white shadow rounded-2xl p-6 max-w-3xl w-full">
            <h1 class="text-3xl font-bold text-blue-600 mb-4 text-center">Serviços Financeiros e Contratuais</h1>

            <ul class="list-disc pl-6 space-y-2 text-gray-700 leading-relaxed">
                <li>Financiamento em prestações.</li>
                <li>Avaliação e retoma de veículos usados.</li>
                <li>Simulação do valor da prestação mensal.</li>
                <li>Contratos explicados com transparência.</li>
            </ul>
        </div>
    </div>
@endsection
