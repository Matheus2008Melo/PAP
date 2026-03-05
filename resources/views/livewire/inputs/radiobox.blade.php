@props([
    'name',
    'model',
    'label' => '',
    'options' => [], // key => value
    'mode' => 'write',
])

<div class="w-full mb-5 flex flex-col">
    
    {{-- Label --}}
    <label class="text-gray-700 mb-2">{{ $label }}</label>

    {{-- Lista de radio buttons --}}
    <div class="flex flex-col gap-2">
        @foreach($options as $key => $value)
            <label class="flex items-center gap-2">
                <input
                    type="radio"
                    name="{{ $name }}"
                    value="{{ $key }}"
                    wire:model="{{ $model }}"
                    class="text-black focus:ring-black"
                    @if($mode == 'show') disabled @endif
                >
                <span>{{ $value }}</span>
            </label>
        @endforeach
    </div>

    {{-- Erro --}}
    @error($name)
        <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
    @enderror

</div>
