<div class="mt-12 border-t border-gray-200 pt-10">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Feedbacks do Projeto</h2>
        
        <!-- 5-Star Rating Section -->
        <div class="flex flex-col items-end" wire:ignore.self>
            @php
                $userHasRated = $hasUserRated ?? false;
            @endphp
            
            <div x-data="{ 
                    hover: 0, 
                    rating: {{ $userHasRated ? $selectedRating : 0 }}
                }" 
                class="flex flex-col items-end gap-3"
            >
                <div class="flex items-center bg-gray-50 rounded-xl px-4 py-2 border border-gray-200">
                    
                    <!-- Estrelas Interativas -->
                    <div class="flex items-center text-2xl mr-3 relative" @mouseleave="hover = 0" class="{{ $userHasRated ? 'opacity-75 cursor-not-allowed' : '' }}">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="relative w-8 h-8 flex items-center justify-center transform transition-transform duration-200 {{ $userHasRated ? '' : 'hover:scale-110 cursor-pointer' }}">
                                
                                <!-- Layer 1: Estrela Vazia (Sempre no fundo) -->
                                <i class="far fa-star text-gray-300 absolute"></i>
                                
                                <!-- Layer 2: Estrela Metade -->
                                <i class="fas fa-star-half text-yellow-400 absolute left-0"
                                   x-show="(hover || rating) == {{ number_format($i - 0.5, 1, '.', '') }}"
                                   x-cloak></i>
                                   
                                <!-- Layer 3: Estrela Cheia -->
                                <i class="fas fa-star text-yellow-400 absolute"
                                   x-show="(hover || rating) >= {{ $i }}"
                                   x-cloak></i>

                                @if(!$userHasRated)
                                    <!-- Hitbox: Clique da Metade Esquerda -->
                                    <div class="absolute left-0 top-0 w-1/2 h-full z-10" 
                                         @mouseenter="hover = {{ number_format($i - 0.5, 1, '.', '') }}" 
                                         @click="rating = {{ number_format($i - 0.5, 1, '.', '') }}; $wire.set('selectedRating', rating)"
                                         title="Dar {{ number_format($i - 0.5, 1, '.', '') }} estrelas"></div>
                                         
                                    <!-- Hitbox: Clique da Metade Direita -->
                                    <div class="absolute right-0 top-0 w-1/2 h-full z-10" 
                                         @mouseenter="hover = {{ $i }}" 
                                         @click="rating = {{ $i }}; $wire.set('selectedRating', rating)"
                                         title="Dar {{ $i }} estrelas"></div>
                                @else
                                    <!-- Overlay de bloqueio quando já votou -->
                                    <div class="absolute inset-0 z-10" title="Avaliação guardada"></div>
                                @endif
                            </div>
                        @endfor
                    </div>

                    @if(Auth::check())
                        <div x-show="rating > 0" x-cloak class="mr-4 text-xs text-green-600 font-medium flex items-center shrink-0">
                            <i class="fas fa-check-circle mr-1"></i> A tua nota: <span class="ml-1" x-text="Number(rating).toFixed(1)"></span>
                        </div>
                    @else
                        <div class="mr-4 text-xs text-gray-500 font-medium shrink-0">
                            <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Inicia sessão</a> para avaliar.
                        </div>
                    @endif
                    
                    <div class="pl-4 border-l border-gray-300 flex flex-col items-center justify-center min-w-[70px]">
                        <span class="text-2xl font-bold leading-none {{ $projeto->rating_average > 0 ? 'text-gray-900' : 'text-gray-400' }}">
                            {{ number_format($projeto->rating_average, 1, '.', '') }}
                        </span>
                        <span class="text-[10px] uppercase font-bold text-gray-500 mt-1 tracking-wider whitespace-nowrap">
                            {{ $projeto->rating_count }} {{ $projeto->rating_count === 1 ? 'VOTO' : 'VOTOS' }}
                        </span>
                    </div>
                </div>

                @if(Auth::check() && !$userHasRated)
                    <button 
                        type="button"
                        x-show="rating > 0" 
                        x-cloak
                        wire:click="rate"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors w-full justify-center sm:w-auto disabled:opacity-50"
                        wire:loading.attr="disabled"
                        wire:target="rate"
                    >
                        <span wire:loading.remove wire:target="rate">Submeter Avaliação</span>
                        <span wire:loading wire:target="rate">A submeter...</span>
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Comentários ({{ $comments->count() }})</h3>
            
            @if(session()->has('comment_message'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                    <p class="text-sm text-green-700">
                        {{ session('comment_message') }}
                    </p>
                </div>
            @endif

            @auth
                <form wire:submit="addComment" class="mb-6">
                    <div class="mb-4">
                        <label for="newComment" class="sr-only">Adicionar um comentário</label>
                        <textarea wire:model="newComment" id="newComment" rows="3" class="shadow-sm block w-full focus:ring-primary-500 focus:border-primary-500 sm:text-sm border border-gray-300 rounded-lg p-3" placeholder="Escreve o teu comentário aqui..."></textarea>
                        @error('newComment') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 disabled:opacity-50" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="addComment">Publicar Comentário</span>
                            <span wire:loading wire:target="addComment">A publicar...</span>
                        </button>
                    </div>
                </form>
            @else
                <div class="bg-gray-50 rounded-lg p-6 text-center mb-6 border border-gray-200 border-dashed">
                    <p class="text-gray-600 mb-4">Inicia sessão para interagir e deixar um comentário.</p>
                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700">
                        Iniciar Sessão
                    </a>
                </div>
            @endauth
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($comments as $comment)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex space-x-4">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $comment->user->avatarUrl() }}" alt="{{ $comment->user->name }}">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">
                                {{ $comment->user->nomeFormatado() }}
                            </p>
                            <p class="text-sm text-gray-500 mb-2">
                                {{ $comment->created_at->diffForHumans() }}
                            </p>
                            <div class="text-sm text-gray-800 whitespace-pre-line">
                                {{ $comment->comment }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <p class="text-base font-medium text-gray-900">Nenhum comentário ainda</p>
                    <p class="text-sm text-gray-500">Sê o primeiro a partilhar a tua opinião sobre este projeto!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
