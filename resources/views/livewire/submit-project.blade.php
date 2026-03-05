<div>
    <div class="bg-white rounded-xl shadow-lg border border-gray-200">
        <div class="p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Submeter Novo Projeto</h1>
            
            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif

            <form wire:submit="submit" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Título do Projeto</label>
                    <input wire:model="titulo" type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('titulo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Disciplina Principal</label>
                    <select wire:model.live="disciplina_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Selecione uma disciplina</option>
                        @foreach($disciplinas as $disciplina)
                            <option value="{{ $disciplina->id }}">{{ $disciplina->nome }}</option>
                        @endforeach
                    </select>
                    @error('disciplina_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Disciplinas Adicionais (Parcerias / Opcional)</label>
                    <div x-data="{ open: false }" @click.away="open = false" class="relative">
                        <!-- Botão principal que imita o dropdown -->
                        <div @click="open = !open" tabindex="0"
                             class="w-full flex justify-between items-center px-4 py-2 bg-white border border-gray-300 rounded-lg cursor-pointer focus:ring-2 focus:ring-blue-500 focus:outline-none min-h-[42px]">
                            
                            <div class="text-sm text-gray-700">
                                @if(is_array($disciplinas_secundarias) && count($disciplinas_secundarias) > 0)
                                    <span class="font-medium text-blue-600">{{ count($disciplinas_secundarias) }} disciplina(s) selecionada(s)</span>
                                @else
                                    <span class="text-gray-500">Selecione as disciplinas parceiras...</span>
                                @endif
                            </div>
                            
                            <svg class="w-4 h-4 text-gray-400 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>

                        <!-- Menu suspenso flutuante com as checkboxes -->
                        <div x-show="open" 
                             style="display: none;"
                             class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-xl max-h-48 overflow-y-auto custom-scrollbar">
                            <div class="p-2 space-y-1">
                                @foreach($disciplinas as $disciplina)
                                    @if($disciplina->id != $disciplina_id)
                                        <label @click.stop class="flex items-center px-3 py-2.5 rounded hover:bg-gray-50 cursor-pointer transition-colors">
                                            <input type="checkbox" wire:model.live="disciplinas_secundarias" value="{{ $disciplina->id }}" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-gray-300 shadow-sm cursor-pointer">
                                            <span class="ml-3 text-sm font-medium text-gray-700">{{ $disciplina->nome }}</span>
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @error('disciplinas_secundarias') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    @error('disciplinas_secundarias.*') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                    <textarea wire:model="descricao" rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    @error('descricao') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ano Letivo</label>
                    <select wire:model="ano_letivo" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Selecione o Ano</option>
                        <option value="2024/2025">2024/2025</option>
                        <option value="2025/2026">2025/2026</option>
                    </select>
                    @error('ano_letivo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Imagem de Capa (Opcional)</label>
                    <input wire:model="imagem" type="file" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <p class="text-xs text-gray-500 mt-1">Apenas imagens até 15MB.</p>
                    @error('imagem') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    
                    <div wire:loading wire:target="imagem" class="text-sm text-blue-600 mt-2">A carregar imagem...</div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ficheiros do Projeto (Obrigatório)</label>
                    <input wire:model="ficheiro" type="file" multiple class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                    <p class="text-xs text-gray-500 mt-1">Podes selecionar vários ficheiros em simultâneo (PDF, Word, Powerpoint, Imagens, ZIPs). Máximo de 150MB por ficheiro.</p>
                    @error('ficheiro') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    @error('ficheiro.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    
                    <div wire:loading wire:target="ficheiro" class="text-sm text-blue-600 mt-2">A carregar ficheiro...</div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tags (Opcional)</label>
                    <input wire:model="tags" type="text" placeholder="Ex: Laravel, PHP, MySQL" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('tags') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div class="pt-6">
                    <button type="submit" class="bg-blue-600 text-white hover:bg-blue-700 px-8 py-3 rounded-lg font-medium transition-colors disabled:opacity-50" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="submit">Submeter Projeto</span>
                        <span wire:loading wire:target="submit">A Submeter...</span>
                    </button>
                    <p class="text-sm text-gray-500 mt-2">O teu projeto ficará pendente de aprovação.</p>
                </div>
            </form>
        </div>
    </div>
</div>
