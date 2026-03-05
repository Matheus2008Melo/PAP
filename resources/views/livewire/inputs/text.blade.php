@props([
    'name',
    'model',
    'label' => '',
    'placeholder' => '',
    'mode' => 'write',
    'type' => 'text',
])

<div class="w-full mb-5 flex flex-col">

    {{-- Label --}}
<div>    
    <label for="{{ $name }}" class="text-gray-700 mb-1">
        {{ $label }}
    </label>
</div>
    {{-- Input --}}
<div>    
        <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        placeholder="{{ $placeholder }}"
        wire:model="{{ $model }}"
        class="px-3 py-2 border border-gray-300 rounded-lg
               focus:outline-none focus:ring-2 focus:ring-black focus:border-black"
        @if ($mode=='show') readonly @endif />
</div>
<div>
        {{-- Erro --}}
    @error($name)
        <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
    @enderror
</div>    
</div>

