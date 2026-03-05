<div>
    <!-- Cabeçalho -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Gestão de Tags</h1>
            <p class="text-gray-600">Gerir tags para classificação de projetos</p>
        </div>
        <a href="{{ route('tags.create') }}" class="btn btn-primary">
            Nova Tag
        </a>
    </div>

    <!-- Filtros -->
    <div class="mb-6 bg-white p-4 rounded-lg shadow-sm border">
        <div class="flex flex-col sm:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <input type="text" wire:model.live="search" placeholder="Pesquisar tags..." 
                       class="w-full rounded-md border-gray-300 shadow-sm">
            </div>
            
            <!-- Filtro Tipo -->
            <select wire:model.live="tipoFilter" class="rounded-md border-gray-300 shadow-sm">
                <option value="">Todos os Tipos</option>
                <option value="ano_escolar">Ano Escolar</option>
                <option value="tecnologia">Tecnologia</option>
                <option value="tema">Tema</option>
            </select>
        </div>
    </div>

    <!-- Tabela -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tag</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Projetos</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($tags as $tag)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full mr-3" style="background-color: {{ $tag->cor }};"></div>
                            <div class="text-sm font-medium text-gray-900">{{ $tag->nome }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($tag->tipo === 'ano_escolar') bg-blue-100 text-blue-800
                            @elseif($tag->tipo === 'tecnologia') bg-green-100 text-green-800
                            @else bg-purple-100 text-purple-800 @endif">
                            {{ ucfirst($tag->tipo) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $tag->projetos_count ?? $tag->projetos->count() }} projetos
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <a href="{{ route('tags.show', $tag) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                        <a href="{{ route('tags.edit', $tag) }}" class="text-green-600 hover:text-green-900">Editar</a>
                        <button wire:click="delete({{ $tag->id }})" 
                                wire:confirm="Tens a certeza que queres eliminar esta tag?"
                                class="text-red-600 hover:text-red-900">Eliminar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginação -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $tags->links() }}
        </div>
    </div>
</div>