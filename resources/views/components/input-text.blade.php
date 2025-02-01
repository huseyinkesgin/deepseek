<div class="w-full">
    <div class="grid grid-cols-3 gap-4 items-center">
        @if($label)
            <label for="{{ $name }}" class="block text-sm font-medium text-red-800">
                {{ $label }}
                @if($required)
                    <span class="text-red-500">*</span>
                @endif
            </label>
        @endif

        <div class="relative rounded-md shadow-sm col-span-2">
            @if($icon)
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="{{ $icon }} text-gray-400"></i>
                </div>
            @endif

            <input
                type="{{ $type }}"
                name="{{ $name }}"
                id="{{ $name }}"
                value="{{ $value }}"
                placeholder="{{ $placeholder }}"
                @if($disabled) disabled @endif
                @if($required) required @endif
                {{ $attributes->merge([
                    'class' => 'block w-full h-7 uppercase border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm' .
                    ($icon ? ' pl-10' : '')
                ]) }}
            >
        </div>
    </div>

    @error($name)
        <div class="grid grid-cols-3 gap-4">
            <div></div>
            <p class="mt-1 text-xs text-red-600 col-span-2">{{ $message }}</p>
        </div>
    @enderror
</div>
