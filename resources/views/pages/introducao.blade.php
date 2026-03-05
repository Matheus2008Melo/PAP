@extends('layouts.app')
<!-- Extende o layout principal 'app', herdando o HTML base, navbar, footer, etc. -->

@section('content')
    <!-- Início da secção de conteúdo principal da página -->

    <div class="flex justify-center items-start min-h-screen p-6 bg-gray-50">
        <!-- Container externo para centralizar o card:
             flex               → ativa flexbox
             justify-center     → centra horizontalmente o card
             items-start        → alinha verticalmente no topo (pode mudar para items-center se quiser verticalmente centrado)
             min-h-screen       → altura mínima igual à altura do ecrã
             p-6                → padding interno de 1.5rem
             bg-gray-50         → fundo cinza claro para destacar o card
        -->

        <div class="bg-white shadow rounded-2xl p-6 max-w-3xl w-full">
            <!-- Card branco centralizado:
                 bg-white           → fundo branco
                 shadow             → sombra para dar profundidade
                 rounded-2xl        → cantos arredondados grandes
                 p-6                → padding interno de 1.5rem
                 max-w-3xl          → largura máxima do card 3xl (~48rem)
                 w-full             → ocupa 100% da largura disponível até o máximo definido
            -->

            <h1 class="text-3xl font-bold text-blue-600 mb-4 text-center">Introdução</h1>
            <!--
                 Título principal:
                 text-3xl          → tamanho grande
                 font-bold         → negrito
                 text-blue-600     → cor azul para destacar
                 mb-4              → margem inferior de 1rem
                 text-center       → centraliza o texto horizontalmente
            -->

            <p class="text-gray-700 leading-relaxed">
                O stand <strong>Manus</strong> é um espaço especializado na exposição, comercialização e assistência de
                automóveis, que tem como principal missão proporcionar ao cliente uma experiência completa e de confiança
                na compra de um automóvel.
            </p>
            <!--
                 Parágrafo:
                 text-gray-700     → cor cinza escuro para melhor leitura
                 leading-relaxed   → aumenta o espaçamento entre linhas (line-height)
                 strong            → destaca "Manus" em negrito
            -->

            <p class="mt-4 text-gray-700 leading-relaxed">
                O seu funcionamento envolve várias áreas interligadas que garantem qualidade no atendimento e eficiência
                nos serviços.
            </p>
            <!--
                 Segundo parágrafo:
                 mt-4              → margem superior de 1rem para separar do parágrafo anterior
                 text-gray-700     → cor cinza escuro
                 leading-relaxed   → espaçamento entre linhas confortável
            -->
        </div>
    </div>
@endsection
<!-- Fim da secção de conteúdo -->
