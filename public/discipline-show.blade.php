<div>
    <!-- Hero Header -->
    <div class="relative overflow-hidden" style="background: {{ $discipline->color }}20; border-color: {{ $discipline->color }}30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-lg" 
                             style="background: {{ $discipline->color }}">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold text-gray-900">{{ $discipline->name }}</h1>
                            <p class="text-gray-600 mt-2">{{ $discipline->description }}</p>
                        </div>
                    </div>
                </div>
                
                @auth
                <a href="{{ route('submit-project') }}" 
                   class="btn-primary mt-4 md:mt-0 text-lg px-6 py-3"
                   style="background: {{ $discipline->color }}; border-color: {{ $discipline->color }}">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Submeter Projeto
                </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Filters and Stats -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <!-- Stats -->
                <div class="flex items-center space-x-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900">{{ $projects->total() }}</div>
                        <div class="text-sm text-gray-500">Projetos</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900">{{ $availableYears->count() }}</div>
                        <div class="text-sm text-gray-500">Anos</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900">{{ $availableTags->count() }}</div>
                        <div class="text-sm text-gray-500">Tags</div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <!-- Year Filter -->
                    <div class="relative">
                        <select wire:model="selectedYear" 
                                class="form-input pl-10 pr-4 appearance-none cursor-pointer">
                            <option value="">Todos os anos</option>
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400 pointer-events-none" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>

                    <!-- Tag Filter -->
                    <div class="relative">
                        <select wire:model="selectedTag" 
                                class="form-input pl-10 pr-4 appearance-none cursor-pointer">
                            <option value="">Todas as tags</option>
                            @foreach($availableTags as $tag)
                                <option value="{{ $tag->slug }}" style="color: {{ $tag->color }}">
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400 pointer-events-none" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>

                    <!-- Sort By -->
                    <div class="relative">
                        <select wire:model="sortBy" 
                                class="form-input pl-10 pr-4 appearance-none cursor-pointer">
                            <option value="newest">Mais recentes</option>
                            <option value="oldest">Mais antigos</option>
                            <option value="popular">Mais populares</option>
                        </select>
                        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400 pointer-events-none" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Projects Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($projects->isEmpty())
            <div class="text-center py-16">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full flex items-center justify-center" 
                     style="background: {{ $discipline->color }}20">
                    <svg class="w-12 h-12" style="color: {{ $discipline->color }}" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Nenhum projeto encontrado</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Ainda não existem projetos nesta disciplina com os filtros selecionados.
                </p>
                @auth
                    <a href="{{ route('submit-project') }}" 
                       class="btn-primary text-lg px-8 py-3"
                       style="background: {{ $discipline->color }}">
                        Seja o primeiro a submeter
                    </a>
                @endauth
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($projects as $project)
                    <div class="card group animate-slide-up" 
                         style="--delay: {{ $loop->index * 50 }}ms">
                        <!-- Project Image -->
                        <div class="relative h-48 overflow-hidden">
                            @if($project->featured_image)
                                <img src="{{ Storage::url($project->featured_image) }}" 
                                     alt="{{ $project->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center" 
                                     style="background: {{ $discipline->color }}20">
                                    <svg class="w-16 h-16" style="color: {{ $discipline->color }}" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Year Badge -->
                            <div class="absolute top-4 left-4">
                                <span class="badge badge-primary bg-white/90 text-gray-700 backdrop-blur-sm">
                                    {{ $project->year }}
                                </span>
                            </div>
                            
                            <!-- Status Badge -->
                            @if($project->status === 'recent')
                                <div class="absolute top-4 right-4">
                                    <span class="badge badge-success">
                                        Novo
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Card Content -->
                        <div class="card-body">
                            <!-- Author -->
                            <div class="flex items-center mb-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center text-white text-sm font-bold mr-3">
                                    {{ substr($project->user->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900 truncate">{{ $project->user->name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $project->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            
                            <!-- Title -->
                            <a href="{{ route('project.show', ['disciplineSlug' => $discipline->slug, 'projectSlug' => $project->slug]) }}" 
                               class="block mb-2">
                                <h3 class="font-bold text-lg text-gray-900 group-hover:text-primary-600 transition-colors line-clamp-2">
                                    {{ $project->title }}
                                </h3>
                            </a>
                            
                            <!-- Description -->
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ $project->excerpt }}
                            </p>
                            
                            <!-- Tags -->
                            @if($project->tags->isNotEmpty())
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach($project->tags->take(3) as $tag)
                                        <span class="badge" style="background: {{ $tag->color }}20; color: {{ $tag->color }}">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                    @if($project->tags->count() > 3)
                                        <span class="badge badge-secondary">
                                            +{{ $project->tags->count() - 3 }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                            
                            <!-- Stats -->
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <div class="flex items-center space-x-4">
                                    <span class="flex items-center hover:text-primary-600 cursor-pointer transition-colors">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                        </svg>
                                        {{ $project->likes_count }}
                                    </span>
                                    <span class="flex items-center hover:text-primary-600 cursor-pointer transition-colors">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        {{ $project->comments->count() }}
                                    </span>
                                </div>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                    4.5
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($projects->hasPages())
                <div class="mt-12">
                    {{ $projects->links() }}
                </div>
            @endif
        @endif
    </div>

    <!-- Popular Tags -->
    @if($availableTags->isNotEmpty())
        <div class="bg-gradient-to-b from-white to-gray-50 border-t border-gray-200 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">Tags Populares</h3>
                <div class="flex flex-wrap justify-center gap-3">
                    @foreach($availableTags->take(15) as $tag)
                        <a href="?tag={{ $tag->slug }}" 
                           class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 hover:scale-105 hover:shadow-md"
                           style="background: {{ $tag->color }}20; color: {{ $tag->color }}">
                            {{ $tag->name }}
                            <span class="ml-1 text-xs opacity-75">({{ $tag->active_projects_count }})</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    .animate-slide-up {
        animation: slideUp 0.5s ease-out;
        animation-delay: calc(var(--delay, 0) * 1ms);
        animation-fill-mode: both;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>