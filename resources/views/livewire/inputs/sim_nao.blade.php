@props([
    'name',
    'model',
    'label' => '',
    'mode' => 'write',
    'yes' => 'Sim',
    'no' => 'Nao',
])

<div class="w-full mb-5 flex flex-col">

    {{-- Label --}}
    <label class="text-gray-700 mb-2">
        {{ $label }}
    </label>

    <div class="flex items-center gap-6">

        {{-- Radio: Desativado --}}
        <label class="flex items-center gap-2">
            <input
                type="radio"
                name="{{ $name }}"
                value="0"
                wire:model="{{ $model }}"
                class="text-black focus:ring-black"
                @if($mode == 'show') disabled @endif
            >
            <span>{{ $no }}</span>
        </label>

        {{-- Radio: Ativo --}}
        <label class="flex items-center gap-2">
            <input
                type="radio"
                name="{{ $name }}"
                value="1"
                wire:model="{{ $model }}"
                class="text-black focus:ring-black"
                @if($mode == 'show') disabled @endif
            >
            <span>{{ $yes }}</span>
        </label>
    </div>

    {{-- Erro --}}
    @error($name)
        <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
    @enderror

</div>
