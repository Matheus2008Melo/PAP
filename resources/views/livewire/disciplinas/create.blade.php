<div>
    <form wire:submit="save">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nome -->
            <div class="md:col-span-2">
                <label for="nome" class="block text-sm font-medium text-gray-700">Nome da Disciplina *</label>
                <input type="text" wire:model="form.nome" id="nome" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                       @if($modo === 'ver') disabled @endif>
                @error('form.nome') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Abreviatura -->
            <div>
                <label for="abreviatura" class="block text-sm font-medium text-gray-700">Abreviatura</label>
                <input type="text" wire:model="form.abreviatura" id="abreviatura" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                       @if($modo === 'ver') disabled @endif>
            </div>

            <!-- Ordem -->
            <div>
                <label for="ordem" class="block text-sm font-medium text-gray-700">Ordem de Apresentação</label>
                <input type="number" wire:model="form.ordem" id="ordem" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                       @if($modo === 'ver') disabled @endif>
                @error('form.ordem') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Cor -->
            <div>
                <label for="cor" class="block text-sm font-medium text-gray-700">Cor</label>
                <input type="color" wire:model="form.cor" id="cor" 
                       class="mt-1 block w-full h-10 rounded-md border-gray-300 shadow-sm"
                       @if($modo === 'ver') disabled @endif>
                @error('form.cor') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Ícone -->
            <div>
                <label for="icone" class="block text-sm font-medium text-gray-700">Ícone (FontAwesome)</label>
                <input type="text" wire:model="form.icone" id="icone" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                       @if($modo === 'ver') disabled @endif>
                @error('form.icone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <label class="inline-flex items-center mt-2">
                    <input type="checkbox" wire:model="form.is_active" 
                           class="rounded border-gray-300 text-blue-600 shadow-sm"
                           @if($modo === 'ver') disabled @endif>
                    <span class="ml-2">Disciplina Ativa</span>
                </label>
            </div>

            <!-- Descrição -->
            <div class="md:col-span-2">
                <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
                <textarea wire:model="form.descricao" id="descricao" rows="3"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                          @if($modo === 'ver') disabled @endif></textarea>
            </div>

            <!-- Botões -->
            @if($modo !== 'ver')
            <div class="md:col-span-2 flex justify-end space-x-4">
                <a href="{{ $index }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    {{ $modo === 'novo' ? 'Criar Disciplina' : 'Atualizar Disciplina' }}
                </button>
            </div>
            @else
            <div class="md:col-span-2 flex justify-end">
                <a href="{{ $index }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Voltar à Lista
                </a>
            </div>
            @endif
        </div>
    </form>
</div>