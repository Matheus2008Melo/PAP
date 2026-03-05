<!-- Navbar topo fixa estilo "Liquid Glass" -->
<nav
    class="sticky top-0 w-full bg-[rgba(255,255,255,0.08)] backdrop-blur-2xl border-b border-[rgba(255,255,255,0.15)] shadow-lg z-50">
    <!--
        sticky top-0      → mantém a navbar sempre visível no topo ao fazer scroll
        w-full            → ocupa 100% da largura do ecrã
        bg-[rgba(255,255,255,0.08)] → fundo semi-transparente, quase vidro
        backdrop-blur-2xl → efeito de desfoque atrás da navbar (Liquid Glass)
        border-b          → borda inferior sutil
        border-[rgba(255,255,255,0.15)] → cor da borda transparente
        shadow-lg         → sombra para dar profundidade
        z-50              → garante que fica acima da maioria dos elementos
    -->

    <div class="max-w-screen-xl mx-auto px-6 py-4 flex items-center justify-between">
        <!--
            max-w-screen-xl → limita a largura máxima do conteúdo da navbar
            mx-auto          → centra o container horizontalmente
            px-6 py-4        → padding horizontal e vertical
            flex             → ativa flexbox
            items-center     → alinha verticalmente os elementos ao centro
            justify-between  → coloca os elementos nas extremidades (logo à esquerda, links à direita)
        -->

        <!-- Logo -->
        <a href="{{ route('introducao') }}" wire:navigate
            class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 drop-shadow-md">
            Stand Manus
        </a>
        <!--
            text-3xl             → tamanho do texto grande
            font-extrabold        → peso da fonte extra-bold
            text-transparent      → texto transparente para aplicar gradiente
            bg-clip-text          → faz o gradiente aplicar-se apenas no texto
            bg-gradient-to-r      → gradiente da esquerda para a direita
            from-indigo-400 via-purple-400 to-pink-400 → cores do gradiente (azul → roxo → rosa)
            drop-shadow-md        → sombra leve para destacar o texto
        -->

        <!-- Links do menu -->
        <div class="flex items-center gap-8 text-lg font-medium text-gray-900">
            <!--
                flex           → organiza os links horizontalmente
                items-center   → alinha verticalmente ao centro
                gap-8          → espaçamento entre os links
                text-lg        → tamanho da fonte dos links
                font-medium    → peso médio da fonte
                text-gray-900  → cor do texto (cinza escuro)
            -->

            <a href="{{ route('introducao') }}" wire:navigate class="hover:text-blue-600 transition-colors duration-300">Introdução</a>
            <!--
                hover:text-blue-600 → muda a cor do link ao passar o mouse
                transition-colors duration-300 → anima a transição da cor em 0.3s
            -->
            <a href="{{ route('exposicao') }}" wire:navigate class="hover:text-blue-600 transition-colors duration-300">Exposição</a>
            <a href="{{ route('atendimento') }}" wire:navigate
                class="hover:text-blue-600 transition-colors duration-300">Atendimento</a>
            <a href="{{ route('testdrive') }}" wire:navigate class="hover:text-blue-600 transition-colors duration-300">Test Drive</a>
            <a href="{{ route('financeiros') }}" wire:navigate
                class="hover:text-blue-600 transition-colors duration-300">Financeiros</a>
            <a href="{{ route('inovacao') }}" wire:navigate class="hover:text-blue-600 transition-colors duration-300">Inovação</a>
            <a href="{{ route('avaliacao') }}" wire:navigate class="hover:text-blue-600 transition-colors duration-300">Avaliação</a>
            <a href="{{ route('casos') }}" wire:navigate class="hover:text-blue-600 transition-colors duration-300">Casos</a>
            <a href="{{ route('omelhorfim') }}" wire:navigate class="hover:text-blue-600 transition-colors duration-300">Fim</a>
            <!-- Cada link segue o mesmo estilo, com hover suave e transição de cores -->
        </div>
    </div>
</nav>
