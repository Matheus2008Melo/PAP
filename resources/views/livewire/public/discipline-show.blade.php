<div>
    <!-- Hero Header -->
    <div class="bg-blue-50 border-b border-blue-100" style="background-color: {{ $disciplina->cor }}10; border-color: {{ $disciplina->cor }}20;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-lg" style="background-color: {{ $disciplina->cor }}">
                            <i class="fas {{ $disciplina->icone }} text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold text-gray-900">{{ $disciplina->nome }}</h1>
                            <p class="text-gray-600 mt-2">{{ $disciplina->descricao }}</p>
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('submit-project') }}" class="bg-blue-600 text-white hover:bg-blue-700 px-6 py-3 rounded-lg font-medium text-lg transition-colors mt-4 md:mt-0" style="background-color: {{ $disciplina->cor }}">
                    Submeter Projeto
                </a>
            </div>
        </div>
    </div>

    <!-- Filters & Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filters -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 space-y-4 md:space-y-0">
            <div class="flex space-x-4">
                <select wire:model.live="selectedAnoLetivo" class="rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos os Anos</option>
                    @foreach($availableAnosLetivos as $ano)
                        <option value="{{ $ano }}">{{ $ano }}</option>
                    @endforeach
                </select>
                
                <select wire:model.live="selectedTag" class="rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todas as Tags</option>
                    @foreach($availableTags as $tag)
                        <option value="{{ $tag->slug }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <select wire:model.live="sortBy" class="rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                <option value="newest">Mais Recentes</option>
                <option value="oldest">Mais Antigos</option>
                <option value="popular">Mais Populares</option>
            </select>
        </div>

        <!-- Projects Grid -->
        @if($projetos->isEmpty())
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas {{ $disciplina->icone }} text-4xl text-gray-400"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Ainda não há projetos</h2>
                <p class="text-gray-600">Seja o primeiro a publicar um projeto em {{ $disciplina->nome }} e inspira outros alunos!</p>
                <a href="{{ route('submit-project') }}" class="inline-block mt-4 text-blue-600 hover:text-blue-800 font-medium">
                    Começar agora &rarr;
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($projetos as $projeto)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 overflow-hidden group">
                        <!-- Project Image -->
                        <div class="relative h-48 bg-gray-200 overflow-hidden">
                            @if($projeto->featured_image)
                                <img src="{{ Storage::url($projeto->featured_image) }}" alt="{{ $projeto->titulo }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute top-2 right-2 bg-white/90 backdrop-blur-sm px-2 py-1 rounded text-xs font-semibold text-gray-700">
                                {{ $projeto->ano_letivo }}º Ano
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-1">
                                <a href="{{ route('project.show', ['disciplineSlug' => $disciplina->slug, 'projectSlug' => $projeto->slug]) }}" wire:navigate class="hover:text-blue-600 transition-colors">
                                    {{ $projeto->titulo }}
                                </a>
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {{ $projeto->descricao }}
                            </p>
                            
                            <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold">
                                        {{ substr($projeto->user->name, 0, 1) }}
                                    </div>
                                    <span class="ml-2 text-sm text-gray-600 truncate max-w-[100px]">{{ $projeto->user->name }}</span>
                                </div>
                                <div class="flex items-center text-gray-500 text-sm space-x-3 font-medium">
                                    <span class="flex items-center text-gray-900" title="Média de Avaliação">
                                        <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        {{ number_format($projeto->rating_average, 1) }}
                                    </span>
                                    <span class="flex items-center" title="Visualizações"><i class="far fa-eye mr-1"></i> {{ $projeto->visitas }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $projetos->links() }}
            </div>
        @endif
    </div>
</div>
