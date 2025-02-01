<div class="w-full">
    <div class="grid grid-cols-3 gap-4 items-start">
        @if($label)
            <label for="{{ $name }}" class="block text-sm font-medium text-red-800 pt-2">
                {{ $label }}
                @if($required)
                    <span class="text-red-500">*</span>
                @endif
            </label>
        @endif

        <div class="relative rounded-md shadow-sm col-span-2">
            <textarea
                name="{{ $name }}"
                id="{{ $name }}"
                rows="{{ $rows }}"
                placeholder="{{ $placeholder }}"
                @if($disabled) disabled @endif
                @if($required) required @endif
                {{ $attributes->merge(['class' => 'block w-full border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm']) }}
            >{{ $value }}</textarea>
        </div>
    </div>

    @error($name)
        <div class="grid grid-cols-3 gap-4">
            <div></div>
            <p class="mt-1 text-xs text-red-600 col-span-2">{{ $message }}</p>
        </div>
    @enderror
</div>
