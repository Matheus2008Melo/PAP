<div class="w-full flex-1 flex flex-col h-[calc(100vh-130px)] bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden">
    <div class="flex-1 flex w-full h-full border-t border-gray-200">
        
        <!-- Sidebar: Conversations List -->
        <div class="w-[280px] flex-shrink-0 border-r border-gray-200 bg-gray-50 flex flex-col h-full">
            <div class="p-5 border-b border-gray-200 bg-white">
                <h2 class="text-xl font-bold text-gray-800">Mensagens</h2>
            </div>
            
            <!-- Active Polling on Sidebar to get unread counts -->
            <div wire:poll.1s class="flex-1 overflow-y-auto">
                @forelse($conversations as $conversation)
                    @php 
                        $otherUser = $conversation->sender_id === auth()->id() ? $conversation->receiver : $conversation->sender;
                        $isActive = $activeConversation && $activeConversation->id === $conversation->id;
                    @endphp
                    <button type="button" 
                         wire:key="conversation-{{ $conversation->id }}" 
                         wire:click="selectConversation({{ $conversation->id }})"
                         class="w-full text-left p-4 border-b border-gray-200 cursor-pointer transition-colors hover:bg-gray-100 {{ $isActive ? 'bg-blue-50 border-l-4 border-l-blue-500' : '' }}">
                        <div class="flex items-center">
                            @if($otherUser->avatar)
                                <img src="{{ Storage::url($otherUser->avatar) }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                    {{ substr($otherUser->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="ml-3 flex-1 overflow-hidden">
                                <h3 class="text-sm font-semibold text-gray-900 truncate">{{ $otherUser->name }}</h3>
                            </div>
                            @if($conversation->unread_count > 0)
                                <span class="bg-blue-600 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full ml-1">{{ $conversation->unread_count }}</span>
                            @endif
                        </div>
                    </button>
                @empty
                    <div class="p-8 text-center text-gray-500">
                        <i class="far fa-comments text-4xl mb-3 text-gray-300"></i>
                        <p>Sem conversas.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Main Panel: Chat Messages -->
        <div class="flex-1 flex flex-col h-full bg-white">
            @if($activeConversation)
                @php 
                    $otherUser = $activeConversation->sender_id === auth()->id() ? $activeConversation->receiver : $activeConversation->sender;
                @endphp
                
                <!-- Chat Header -->
                <div wire:key="chat-header-{{ $activeConversation->id }}" class="p-4 border-b border-gray-200 flex items-center justify-between bg-white z-10">
                    <div class="flex items-center">
                        @if($otherUser->avatar)
                            <img src="{{ Storage::url($otherUser->avatar) }}" class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                {{ substr($otherUser->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="ml-3">
                            <h2 class="text-lg font-bold text-gray-900">{{ $otherUser->name }}</h2>
                            <p class="text-xs text-blue-600 font-medium">{{ $otherUser->curso }}</p>
                        </div>
                    </div>
                </div>

                <!-- Chat Messages Area (Polling every 1 second) -->
                <div wire:poll.1s class="flex-1 overflow-y-auto p-6 bg-gray-50 flex flex-col space-y-4" id="messages-container">
                    @forelse($activeConversation->messages as $message)
                        @php 
                            $isMine = $message->user_id === auth()->id();
                        @endphp
                        <div wire:key="message-{{ $message->id }}" class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[70%] {{ $isMine ? 'bg-blue-600 text-white rounded-br-none' : 'bg-white text-gray-800 rounded-bl-none border border-gray-200 shadow-sm' }}  rounded-2xl px-5 py-3 relative">
                                <p class="text-sm leading-relaxed whitespace-pre-wrap">{{ $message->body }}</p>
                                <div class="text-[10px] mt-1 text-right {{ $isMine ? 'text-blue-100' : 'text-gray-400' }}">
                                    {{ $message->created_at->format('H:i') }}
                                    @if($isMine)
                                        <i class="fas max-w-fit {{ $message->read_at ? 'fa-check-double text-blue-200' : 'fa-check text-blue-300' }} ml-1"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex-1 flex flex-col items-center justify-center text-gray-400">
                            <i class="far fa-hand-wave text-5xl mb-4 text-blue-200"></i>
                            <p class="text-lg">Diz olá ao {{ $otherUser->name }}!</p>
                            <p class="text-sm text-gray-500 mt-1">Este é o início da vossa conversa.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Chat Input Box -->
                <div class="p-4 bg-white border-t border-gray-200">
                    <form wire:submit="sendMessage" x-on:submit="$refs.msgBox.value = ''" class="flex items-end gap-3 w-full">
                        <div class="flex-1">
                            <textarea wire:model="body"
                                      x-ref="msgBox"
                                      x-on:keydown.enter.prevent="$wire.sendMessage().then(() => { $refs.msgBox.value = '' })"
                                      rows="2" 
                                      class="w-full border-gray-300 rounded-xl focus:border-blue-500 focus:ring focus:ring-blue-200 transition-shadow resize-none p-3 shadow-sm" 
                                      placeholder="Escreve a tua mensagem..."></textarea>
                            @error('body') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-6 py-4 font-medium transition-colors mb-[2px] shadow-sm flex items-center justify-center h-[52px]">
                            <i class="fas fa-paper-plane mr-2"></i> Enviar
                        </button>
                    </form>
                </div>
            @else
                <!-- No Conversation Selected State -->
                <div class="flex-1 flex flex-col items-center justify-center bg-gray-50 text-gray-400">
                    <div class="w-24 h-24 bg-white rounded-full shadow-sm flex items-center justify-center mb-6">
                        <i class="far fa-comment-dots text-4xl text-blue-500"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-700 mb-2">As tuas Mensagens</h2>
                    <p class="text-gray-500 max-w-md text-center">Seleciona uma conversa no menu à esquerda ou inicia uma nova conversa a partir do perfil de um projeto.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Scroll to bottom of chat when updated
    document.addEventListener('livewire:initialized', () => {
        const scrollToBottom = () => {
            const container = document.getElementById('messages-container');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        };

        // Scroll on load
        scrollToBottom();

        // Scroll after Livewire updates
        Livewire.hook('morph.updated', ({ component, el }) => {
            scrollToBottom();
        });
    });
</script>
