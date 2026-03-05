@props([
    'name',
    'model',
    'label' => '',
    'options' => [], // key => value
    'placeholder' => 'Selecione...',
    'mode' => 'write',
])

<div class="w-full mb-5 flex flex-col">

    {{-- Label --}}
    <label for="{{ $name }}" class="text-gray-700 mb-1">{{ $label }}</label>

    {{-- Select --}}
    <select
        name="{{ $name }}"
        id="{{ $name }}"
        wire:model="{{ $model }}"
        class="px-3 py-2 border border-gray-300 rounded-lg bg-white
               focus:outline-none focus:ring-2 focus:ring-black focus:border-black"
        @if($mode == 'show') disabled @endif
    >
        <option value="" disabled selected>{{ $placeholder }}</option>

        @foreach($options as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select>

    {{-- Erro --}}
    @error($name)
        <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
    @enderror
</div>
