@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Breadcrumbs & Admin Actions -->
    <div class="flex items-center justify-between mb-6">
        <div class="text-sm text-gray-500">
            <a href="{{ route('home') }}" wire:navigate class="hover:text-blue-600">Início</a> >
            <a href="{{ route('discipline.show', $disciplina->slug) }}" wire:navigate class="hover:text-blue-600">{{ $disciplina->nome }}</a> >
            <span class="text-gray-900 font-medium">{{ $projeto->titulo }}</span>
        </div>

        @auth
            @if(auth()->user()->role === 'admin')
                <form action="{{ route('project.destroy', $projeto->id) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja eliminar permanentemente este projeto? Esta ação não pode ser desfeita.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow transition-colors flex items-center">
                        <i class="fas fa-trash-alt mr-2"></i> Eliminar Projeto
                    </button>
                </form>
            @endif
        @endauth
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <!-- Hero Image (if exists) -->
        @if($projeto->featured_image)
            <div class="w-full h-64 md:h-96 bg-gray-200">
                <img src="{{ Storage::url($projeto->featured_image) }}" alt="{{ $projeto->titulo }}" class="w-full h-full object-cover">
            </div>
        @else
            <div class="w-full h-48 md:h-64 flex flex-col items-center justify-center text-white" style="background-color: {{ $disciplina->cor ?: '#3B82F6' }}">
                <i class="fas {{ $disciplina->icone ?: 'fa-project-diagram' }} text-6xl mb-4"></i>
                <h1 class="text-3xl md:text-5xl font-bold">{{ $projeto->titulo }}</h1>
            </div>
        @endif

        <div class="p-8">
            <!-- Header Content -->
            @if($projeto->featured_image)
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $projeto->titulo }}</h1>
            @endif
            
            <div class="flex flex-wrap items-center justify-between mb-8 pb-6 border-b border-gray-100">
                <!-- Author Info -->
                <div class="flex items-center space-x-4 mb-4 md:mb-0">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-lg font-bold">
                        {{ substr($projeto->user->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <p class="text-gray-900 font-semibold">{{ $projeto->user->name }}</p>
                            @if(auth()->check() && auth()->id() === $projeto->user_id)
                                <span class="text-xs bg-gray-100 text-gray-500 border border-gray-200 px-2 py-1 rounded-full inline-flex items-center font-semibold shadow-sm ml-2" title="Não podes enviar uma mensagem a ti próprio">
                                    <i class="fas fa-user-check mr-1"></i> És o Autor
                                </span>
                            @else
                                <a href="{{ route('chat', $projeto->user_id) }}" wire:navigate 
                                   class="text-xs bg-blue-50 text-blue-600 hover:bg-blue-100 border border-blue-200 px-2 py-1 rounded-full transition-colors inline-flex items-center font-semibold shadow-sm ml-2" title="Enviar mensagem ao autor">
                                    <i class="fas fa-comment-dots mr-1"></i> Contactar Autor
                                </a>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500">Publicado a {{ $projeto->published_at ? \Carbon\Carbon::parse($projeto->published_at)->format('d/m/Y') : $projeto->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>

                <!-- Tags / Year Label -->
                <div class="flex flex-col items-end space-y-3">
                    <div class="flex items-center space-x-2">
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">
                            {{ $projeto->ano_letivo }}º Ano
                        </span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold border border-blue-200" title="Disciplina Principal">
                            <i class="fas fa-book mr-1"></i> {{ $disciplina->nome }}
                        </span>
                    </div>
                    
                    @if($projeto->disciplinasSecundarias->count() > 0)
                        <div class="flex items-center flex-wrap gap-2 justify-end">
                            <span class="text-xs text-gray-500 font-medium mr-1">Parceria:</span>
                            @foreach($projeto->disciplinasSecundarias as $sec)
                                <a href="{{ route('discipline.show', $sec->slug) }}" class="px-2 py-1 bg-purple-50 text-purple-700 rounded text-xs font-semibold border border-purple-200 hover:bg-purple-100 transition-colors">
                                    {{ $sec->nome }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    @if($projeto->tags->count() > 0)
                        <div class="flex flex-wrap gap-2 justify-end">
                            @foreach($projeto->tags as $tag)
                                <span class="px-2 py-1 bg-gray-50 text-gray-600 rounded text-xs font-semibold border border-gray-200">
                                    #{{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Project Content -->
            <div class="prose max-w-none text-gray-700 mb-10">
                @if($projeto->descricao_curta)
                    <p class="text-xl font-medium text-gray-600 mb-6 italic">{{ $projeto->descricao_curta }}</p>
                @endif
                
                <div class="mt-4 whitespace-pre-wrap leading-relaxed">
                    {{ $projeto->descricao }}
                </div>
            </div>

            <!-- External Link and Attachments -->
            <div class="mt-8 pt-6 border-t border-gray-100 flex flex-wrap gap-4">
                @if($projeto->url_externa)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Links Externos</h3>
                        <a href="{{ $projeto->url_externa }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-4 py-2 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-lg text-blue-600 hover:text-blue-700 transition-colors font-medium">
                            <i class="fas fa-external-link-alt mr-2"></i> Abrir Link
                        </a>
                    </div>
                @endif

                @if($projeto->anexos && $projeto->anexos->count() > 0)
                    <div class="w-full mt-10" x-data="{ showFiles: true }">
                        <div class="flex items-center justify-between mb-6 border-b border-gray-200 pb-2">
                            <h3 class="text-2xl font-bold text-gray-900 border-b-2 border-blue-500 pb-1 inline-block">Ficheiros do Projeto ({{ $projeto->anexos->count() }})</h3>
                            
                            <button @click="showFiles = !showFiles" 
                                    class="flex items-center space-x-2 px-3 py-1.5 rounded-lg bg-gray-50 hover:bg-blue-50 text-gray-600 hover:text-blue-600 border border-gray-200 hover:border-blue-200 transition-all duration-300 text-sm font-semibold shadow-sm group">
                                <i class="fas transition-transform duration-300" :class="showFiles ? 'fa-eye-slash group-hover:scale-110' : 'fa-eye group-hover:scale-110'"></i>
                                <span x-text="showFiles ? 'Ocultar Ficheiros' : 'Mostrar Ficheiros'"></span>
                            </button>
                        </div>
                        
                        <div x-show="showFiles" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform -translate-y-4"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform -translate-y-4"
                             class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($projeto->anexos as $anexo)
                                <div class="bg-gray-50 rounded-xl overflow-hidden shadow-sm border border-gray-200 relative group flex flex-col h-[400px]">
                                    <!-- File Header Bar -->
                                    <div class="bg-gray-100 px-4 py-3 border-b border-gray-200 flex items-center justify-between shadow-sm z-10">
                                        <div class="flex items-center space-x-2 truncate">
                                            @if(in_array(strtolower($anexo->extensao), ['jpg', 'jpeg', 'png', 'gif', 'svg']))
                                                <i class="fas fa-image text-blue-500"></i>
                                            @elseif(strtolower($anexo->extensao) === 'pdf')
                                                <i class="fas fa-file-pdf text-red-500"></i>
                                            @elseif(in_array(strtolower($anexo->extensao), ['zip', 'rar']))
                                                <i class="fas fa-file-archive text-yellow-600"></i>
                                            @else
                                                <i class="fas fa-file text-gray-500"></i>
                                            @endif
                                            <span class="text-sm font-semibold text-gray-700 truncate" title="{{ $anexo->nome_original }}">{{ Str::limit($anexo->nome_original, 30) }}</span>
                                        </div>
                                        <div class="flex items-center space-x-2 shrink-0">
                                            <span class="text-xs text-gray-500 bg-white px-2 py-1 rounded border border-gray-200">{{ number_format($anexo->tamanho / 1048576, 1) }} MB</span>
                                            <a href="{{ route('anexo.download', $anexo->id) }}" class="text-gray-500 hover:text-blue-600 transition-colors" title="Descarregar {{ $anexo->nome_original }}">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Viewer Body -->
                                    <div class="flex-grow w-full relative bg-gray-900 flex items-center justify-center overflow-hidden">
                                        @if(in_array(strtolower($anexo->extensao), ['jpg', 'jpeg', 'png', 'gif', 'svg']))
                                            <a href="{{ route('anexo.preview', $anexo->id) }}" target="_blank" class="w-full h-full block">
                                                <img src="{{ route('anexo.preview', $anexo->id) }}" alt="{{ $anexo->nome_original }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                            </a>
                                        @elseif(strtolower($anexo->extensao) === 'pdf')
                                            <iframe src="{{ route('anexo.preview', $anexo->id) }}#view=FitH&toolbar=0&navpanes=0" class="w-full h-full border-none bg-white" title="Visualizador de PDF"></iframe>
                                        @else
                                            <div class="flex flex-col items-center justify-center text-center p-6 text-gray-400 w-full h-full">
                                                <div class="w-16 h-16 rounded-full bg-gray-800 flex items-center justify-center mb-4">
                                                    <i class="fas fa-file-download text-2xl text-gray-300"></i>
                                                </div>
                                                <p class="text-sm font-medium text-white mb-1">Visualização Indisponível</p>
                                                <p class="text-xs mb-4">Para visualizar este ficheiro ({{ strtoupper($anexo->extensao) }}), deverá descarregá-lo.</p>
                                                <a href="{{ route('anexo.download', $anexo->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm font-medium transition-colors shadow-sm">
                                                    Descarregar
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Interações (Comentários e Votos) -->
            @livewire('project-interactions', ['projeto' => $projeto])

        </div>
        
    </div>
</div>
@endsection
