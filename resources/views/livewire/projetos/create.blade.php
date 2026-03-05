<div>
    <form wire:submit="save">
        <div class="grid grid-cols-1 gap-6">
            <!-- Título -->
            <div>
                <label for="titulo" class="block text-sm font-medium text-gray-700">Título do Projeto</label>
                <input type="text" wire:model="form.titulo" id="titulo" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                       @if($modo === 'ver') disabled @endif>
                @error('form.titulo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Disciplina -->
            <div>
                <label for="disciplina_id" class="block text-sm font-medium text-gray-700">Disciplina</label>
                <select wire:model="form.disciplina_id" id="disciplina_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        @if($modo === 'ver') disabled @endif>
                    <option value="">Selecione uma disciplina</option>
                    @foreach($disciplinas as $disciplina)
                        <option value="{{ $disciplina->id }}">{{ $disciplina->nome }}</option>
                    @endforeach
                </select>
                @error('form.disciplina_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Descrição Curta -->
            <div>
                <label for="descricao_curta" class="block text-sm font-medium text-gray-700">Descrição Curta</label>
                <textarea wire:model="form.descricao_curta" id="descricao_curta" rows="2"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                          @if($modo === 'ver') disabled @endif></textarea>
            </div>

            <!-- Descrição Completa -->
            <div>
                <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição Completa</label>
                <textarea wire:model="form.descricao" id="descricao" rows="5"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                          @if($modo === 'ver') disabled @endif></textarea>
                @error('form.descricao') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Ano Letivo -->
            <div>
                <label for="ano_letivo" class="block text-sm font-medium text-gray-700">Ano Letivo</label>
                <input type="text" wire:model="form.ano_letivo" id="ano_letivo" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                       @if($modo === 'ver') disabled @endif>
                @error('form.ano_letivo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Tags (Anos Escolares) -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Anos de Escolaridade</label>
                <div class="mt-2 space-y-2">
                    @foreach($tags as $tag)
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="form.tags" value="{{ $tag->id }}"
                                   class="rounded border-gray-300 text-blue-600 shadow-sm"
                                   @if($modo === 'ver') disabled @endif>
                            <span class="ml-2">{{ $tag->nome }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Status (apenas para admin) -->
            @if(auth()->user()->isAdmin())
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select wire:model="form.status" id="status"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="pendente">Pendente</option>
                    <option value="aprovado">Aprovado</option>
                    <option value="rejeitado">Rejeitado</option>
                    <option value="rascunho">Rascunho</option>
                </select>
            </div>

            <!-- Featured -->
            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" wire:model="form.is_featured" 
                           class="rounded border-gray-300 text-blue-600 shadow-sm">
                    <span class="ml-2">Projeto em Destaque</span>
                </label>
            </div>
            @endif

            <!-- Botões -->
            @if($modo !== 'ver')
            <div class="flex justify-end space-x-4">
                <a href="{{ $index }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    {{ $modo === 'novo' ? 'Criar Projeto' : 'Atualizar Projeto' }}
                </button>
            </div>
            @else
            <div class="flex justify-end">
                <a href="{{ $index }}" class="btn btn-secondary">Voltar</a>
            </div>
            @endif
        </div>
    </form>
</div>