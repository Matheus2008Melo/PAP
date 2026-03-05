<div>
    <form wire:submit="save">
        <div class="grid grid-cols-1 gap-6 max-w-2xl">
            <!-- Nome -->
            <div>
                <label for="nome" class="block text-sm font-medium text-gray-700">Nome da Tag *</label>
                <input type="text" wire:model="form.nome" id="nome" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                       @if($modo === 'ver') disabled @endif>
                @error('form.nome') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Tipo -->
            <div>
                <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo de Tag *</label>
                <select wire:model="form.tipo" id="tipo"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        @if($modo === 'ver') disabled @endif>
                    <option value="ano_escolar">Ano Escolar</option>
                    <option value="tecnologia">Tecnologia</option>
                    <option value="tema">Tema</option>
                </select>
                @error('form.tipo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Cor -->
            <div>
                <label for="cor" class="block text-sm font-medium text-gray-700">Cor</label>
                <input type="color" wire:model="form.cor" id="cor" 
                       class="mt-1 block w-full h-10 rounded-md border-gray-300 shadow-sm"
                       @if($modo === 'ver') disabled @endif>
                @error('form.cor') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Botões -->
            @if($modo !== 'ver')
            <div class="flex justify-end space-x-4">
                <a href="{{ $index }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    {{ $modo === 'novo' ? 'Criar Tag' : 'Atualizar Tag' }}
                </button>
            </div>
            @else
            <div class="flex justify-end">
                <a href="{{ $index }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Voltar à Lista
                </a>
            </div>
            @endif
        </div>
    </form>
</div>