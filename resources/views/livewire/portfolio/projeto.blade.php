<div x-data="{ showShare: false }" class="min-h-screen bg-gray-50">
    <!-- Breadcrumb -->
    <nav class="bg-white border-b">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center text-sm text-gray-600">
                <a href="{{ route('home') }}" wire:navigate class="hover:text-blue-600">WeAreSchool</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                <a href="{{ route('portfolio.disciplina', $projeto->disciplina->slug) }}" wire:navigate class="hover:text-blue-600">{{ $projeto->disciplina->nome }}</a>
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                <span class="text-gray-900 font-medium">{{ $projeto->titulo }}</span>
            </div>
        </div>
    </nav>

    <!-- Hero do Projeto -->
    <div class="bg-white">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Conteúdo Principal -->
                <div class="lg:col-span-2">
                    <!-- Tags e Disciplina -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold" 
                              style="background-color: {{ $projeto->disciplina->cor }}20; color: {{ $projeto->disciplina->cor }};">
                            <i class="{{ $projeto->disciplina->icone }} mr-2"></i>
                            {{ $projeto->disciplina->nome }}
                        </span>
                        @foreach($projeto->tags as $tag)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border"
                              style="border-color: {{ $tag->cor }}; color: {{ $tag->cor }};">
                            {{ $tag->nome }}
                        </span>
                        @endforeach
                    </div>

                    <!-- Título -->
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $projeto->titulo }}</h1>

                    <!-- Autor e Data -->
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center">
                            @if($projeto->user->avatar)
                            <img src="{{ Storage::url($projeto->user->avatar) }}" 
                                 class="w-10 h-10 rounded-full mr-3">
                            @else
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                                {{ substr($projeto->user->name, 0, 1) }}
                            </div>
                            @endif
                            <div>
                                <div class="font-medium flex items-center flex-wrap gap-2">
                                    <span>{{ $projeto->user->name }}</span>
                                    @if(auth()->check() && auth()->id() === $projeto->user_id)
                                        <span class="text-xs bg-gray-100 text-gray-500 border border-gray-200 px-2 py-1 rounded-full inline-flex items-center font-semibold shadow-sm" title="Não podes enviar uma mensagem a ti próprio">
                                            <i class="fas fa-user-check mr-1"></i> És o Autor
                                        </span>
                                    @else
                                        <a href="{{ route('chat', $projeto->user_id) }}" wire:navigate 
                                           class="text-xs bg-blue-50 text-blue-600 hover:bg-blue-100 border border-blue-200 px-2 py-1 rounded-full transition-colors inline-flex items-center font-semibold shadow-sm">
                                            <i class="fas fa-comment-dots mr-1"></i> Contactar Autor
                                        </a>
                                    @endif
                                </div>
                                <div class="text-sm text-gray-500">
                                    Publicado {{ $projeto->published_at->diffForHumans() }}
                                    • {{ $projeto->visitas }} visualizações
                                </div>
                            </div>
                        </div>

                        <!-- Sistema de Votos -->
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2">
                                <button wire:click="vote('upvote')" 
                                        class="p-2 rounded-full hover:bg-gray-100 transition"
                                        title="Gostei deste projeto">
                                    <svg class="w-6 h-6 {{ $projeto->votes()->where('user_id', auth()->id())->where('type', 'upvote')->exists() ? 'text-green-500' : 'text-gray-400' }}" 
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                <span class="text-xl font-bold text-gray-900">{{ $projeto->vote_score }}</span>
                                <button wire:click="vote('downvote')" 
                                        class="p-2 rounded-full hover:bg-gray-100 transition"
                                        title="Não gostei">
                                    <svg class="w-6 h-6 {{ $projeto->votes()->where('user_id', auth()->id())->where('type', 'downvote')->exists() ? 'text-red-500' : 'text-gray-400' }}" 
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- Botão Partilhar -->
                            <button @click="showShare = !showShare" 
                                    class="p-2 rounded-full hover:bg-gray-100 transition">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Imagem Principal -->
                    @if($projeto->featured_image)
                    <div class="mb-8 rounded-xl overflow-hidden shadow-lg">
                        <img src="{{ Storage::url($projeto->featured_image) }}" 
                             alt="{{ $projeto->titulo }}" 
                             class="w-full h-auto">
                    </div>
                    @endif

                    <!-- Descrição -->
                    <div class="prose max-w-none mb-8">
                        <h2 class="text-2xl font-bold mb-4">Sobre este projeto</h2>
                        <div class="text-gray-700 leading-relaxed">
                            {!! nl2br(e($projeto->descricao)) !!}
                        </div>
                    </div>

                    <!-- Metadados -->
                    @if($projeto->metadados)
                    <div class="bg-gray-50 rounded-xl p-6 mb-8">
                        <h3 class="text-xl font-bold mb-4">Detalhes Técnicos</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($projeto->metadados as $key => $value)
                            <div>
                                <span class="font-medium text-gray-700">{{ ucfirst($key) }}:</span>
                                @if(is_array($value))
                                <span class="text-gray-600">{{ implode(', ', $value) }}</span>
                                @else
                                <span class="text-gray-600">{{ $value }}</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Links Externos -->
                    @if($projeto->url_externa)
                    <div class="mb-8">
                        <a href="{{ $projeto->url_externa }}" target="_blank" 
                           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Ver Projeto Online
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Estatísticas -->
                    <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
                        <h3 class="text-lg font-bold mb-4">Estatísticas</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Visualizações</span>
                                <span class="font-medium">{{ $projeto->visitas }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Upvotes</span>
                                <span class="font-medium text-green-600">{{ $projeto->upvotes }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Downvotes</span>
                                <span class="font-medium text-red-600">{{ $projeto->downvotes }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Comentários</span>
                                <span class="font-medium">{{ $projeto->comments->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Partilhar (Dropdown) -->
                    <div x-show="showShare" x-cloak 
                         class="bg-white rounded-xl shadow-lg border p-6 mb-6">
                        <h3 class="text-lg font-bold mb-4">Partilhar Projeto</h3>
                        <div class="space-y-3">
                            <button @click="navigator.share({title: '{{ $projeto->titulo }}', url: window.location.href})" 
                                    class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                </svg>
                                Partilhar
                            </button>
                            <div class="text-center text-sm text-gray-500">
                                Ou copia o link:
                            </div>
                            <div class="flex">
                                <input type="text" readonly value="{{ url()->current() }}" 
                                       class="flex-1 px-3 py-2 border rounded-l-lg text-sm">
                                <button @click="navigator.clipboard.writeText('{{ url()->current() }}')" 
                                        class="px-4 py-2 bg-gray-100 border border-l-0 rounded-r-lg hover:bg-gray-200">
                                    Copiar
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Projetos Relacionados -->
                    <div class="bg-white rounded-xl shadow-sm border p-6">
                        <h3 class="text-lg font-bold mb-4">Mais de {{ $projeto->disciplina->nome }}</h3>
                        <div class="space-y-4">
                            @foreach($projeto->disciplina->projetos()->where('status', 'aprovado')->where('id', '!=', $projeto->id)->limit(3)->get() as $related)
                            <a href="{{ route('portfolio.projeto', $related->slug) }}" wire:navigate
                               class="block hover:bg-gray-50 p-3 rounded-lg transition">
                                <div class="font-medium">{{ $related->titulo }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($related->descricao_curta, 60) }}</div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECÇÃO DE COMENTÁRIOS -->
    <div class="bg-white border-t">
        <div class="container mx-auto px-4 py-8">
            <h2 class="text-2xl font-bold mb-6">Comentários ({{ $projeto->comments->count() }})</h2>

            <!-- Formulário de Comentário -->
            @auth
            <div class="mb-8">
                <form wire:submit="addComment">
                    <div class="flex items-start space-x-4">
                        @if(auth()->user()->avatar)
                        <img src="{{ Storage::url(auth()->user()->avatar) }}" 
                             class="w-10 h-10 rounded-full">
                        @else
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        @endif
                        <div class="flex-1">
                            <textarea wire:model="comment" 
                                      id="comment-input"
                                      rows="3" 
                                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                      placeholder="{{ $replyTo ? 'A responder a um comentário...' : 'Adiciona um comentário construtivo...' }}"></textarea>
                            @error('comment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            <div class="flex justify-between items-center mt-2">
                                @if($replyTo)
                                <div class="text-sm text-blue-600">
                                    <button type="button" wire:click="$set('replyTo', null)" 
                                            class="hover:text-blue-800">
                                        ✕ Cancelar resposta
                                    </button>
                                </div>
                                @else
                                <div class="text-sm text-gray-500">
                                    Os comentários são públicos
                                </div>
                                @endif
                                <button type="submit" 
                                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    Comentar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @else
            <div class="bg-gray-50 rounded-lg p-6 text-center mb-8">
                <p class="mb-4">Inicia sessão para participares na discussão</p>
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Iniciar Sessão
                </a>
            </div>
            @endauth

            <!-- Lista de Comentários -->
            <div class="space-y-6">
                @foreach($projeto->comments->whereNull('parent_id') as $comment)
                <div class="border rounded-xl p-6">
                    <!-- Comentário Principal -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center">
                            @if($comment->user->avatar)
                            <img src="{{ Storage::url($comment->user->avatar) }}" 
                                 class="w-10 h-10 rounded-full mr-3">
                            @else
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                                {{ substr($comment->user->name, 0, 1) }}
                            </div>
                            @endif
                            <div>
                                <div class="font-medium">{{ $comment->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        
                        <!-- Votos do Comentário -->
                        <div class="flex items-center space-x-2">
                            <button wire:click="voteComment({{ $comment->id }}, 'upvote')" 
                                    class="p-1 hover:bg-gray-100 rounded">
                                <svg class="w-5 h-5 {{ $comment->votes()->where('user_id', auth()->id())->where('type', 'upvote')->exists() ? 'text-green-500' : 'text-gray-400' }}" 
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                            <span class="font-medium {{ $comment->vote_score >= 0 ? 'text-gray-900' : 'text-red-600' }}">
                                {{ $comment->vote_score }}
                            </span>
                            <button wire:click="voteComment({{ $comment->id }}, 'downvote')" 
                                    class="p-1 hover:bg-gray-100 rounded">
                                <svg class="w-5 h-5 {{ $comment->votes()->where('user_id', auth()->id())->where('type', 'downvote')->exists() ? 'text-red-500' : 'text-gray-400' }}" 
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Texto do Comentário -->
                    <div class="mb-4">
                        <p class="text-gray-700">{{ $comment->comment }}</p>
                    </div>

                    <!-- Ações -->
                    <div class="flex items-center space-x-4">
                        @auth
                        <button wire:click="setReply({{ $comment->id }})" 
                                class="text-sm text-blue-600 hover:text-blue-800">
                            Responder
                        </button>
                        @if(auth()->id() === $comment->user_id || auth()->user()->isAdmin())
                        <button wire:click="deleteComment({{ $comment->id }})" 
                                wire:confirm="Eliminar este comentário?"
                                class="text-sm text-red-600 hover:text-red-800">
                            Eliminar
                        </button>
                        @endif
                        @endauth
                    </div>

                    <!-- Respostas -->
                    @if($comment->replies->count() > 0)
                    <div class="mt-6 ml-10 space-y-4">
                        @foreach($comment->replies as $reply)
                        <div class="border-l-2 border-gray-200 pl-4 py-2">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center">
                                    @if($reply->user->avatar)
                                    <img src="{{ Storage::url($reply->user->avatar) }}" 
                                         class="w-8 h-8 rounded-full mr-3">
                                    @else
                                    <div class="w-8 h-8 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center mr-3">
                                        {{ substr($reply->user->name, 0, 1) }}
                                    </div>
                                    @endif
                                    <div>
                                        <div class="font-medium">{{ $reply->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <p class="text-gray-700 text-sm">{{ $reply->comment }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endforeach

                @if($projeto->comments->count() === 0)
                <div class="text-center py-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">Ainda sem comentários</h3>
                    <p class="text-gray-600">Sê o primeiro a comentar este projeto!</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@script
<script>
    // Focus no input quando reply é selecionado
    Livewire.on('focus-comment-input', () => {
        document.getElementById('comment-input').focus();
    });
</script>
@endscript