<div>
    <!-- Cabeçalho com Filtros -->
    <div class="mb-6 space-y-4">
        <div class="flex flex-col sm:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <input type="text" wire:model.live="search" placeholder="Pesquisar projetos..." 
                       class="w-full rounded-md border-gray-300 shadow-sm">
            </div>
            
            <!-- Filtro Disciplina -->
            <select wire:model.live="disciplinaFilter" class="rounded-md border-gray-300 shadow-sm">
                <option value="">Todas as Disciplinas</option>
                @foreach($disciplinas as $disciplina)
                    <option value="{{ $disciplina->id }}">{{ $disciplina->nome }}</option>
                @endforeach
            </select>

            <!-- Filtro Status -->
            <select wire:model.live="statusFilter" class="rounded-md border-gray-300 shadow-sm">
                <option value="">Todos os Status</option>
                <option value="pendente">Pendente</option>
                <option value="aprovado">Aprovado</option>
                <option value="rejeitado">Rejeitado</option>
            </select>

            <!-- Botão Novo -->
            <a href="{{ route('projetos.create') }}" class="btn btn-primary">
                Novo Projeto
            </a>
        </div>
    </div>

    <!-- Tabela de Projetos -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Título</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Disciplina</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($projetos as $projeto)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $projeto->titulo }}</div>
                        <div class="text-sm text-gray-500">{{ Str::limit($projeto->descricao_curta, 50) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                              style="background-color: {{ $projeto->disciplina->cor }}20; color: {{ $projeto->disciplina->cor }};">
                            {{ $projeto->disciplina->nome }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($projeto->status === 'aprovado') bg-green-100 text-green-800
                            @elseif($projeto->status === 'pendente') bg-yellow-100 text-yellow-800
                            @elseif($projeto->status === 'rejeitado') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($projeto->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $projeto->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <a href="{{ route('projetos.show', $projeto) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                        <a href="{{ route('projetos.edit', $projeto) }}" class="text-green-600 hover:text-green-900">Editar</a>
                        
                        @if(auth()->user()->isAdmin() && $projeto->status === 'pendente')
                        <button wire:click="approve({{ $projeto->id }})" 
                                class="text-green-600 hover:text-green-900">Aprovar</button>
                        @endif
                        
                        <button wire:click="delete({{ $projeto->id }})" 
                                wire:confirm="Tens a certeza que queres eliminar este projeto?"
                                class="text-red-600 hover:text-red-900">Eliminar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginação -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $projetos->links() }}
        </div>
    </div>
</div>