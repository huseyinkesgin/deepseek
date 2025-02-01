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
            <select
                name="{{ $name }}"
                id="{{ $name }}"
                @if($disabled) disabled @endif
                @if($required) required @endif
                {{ $attributes->merge(['class' => 'block w-full h-7 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm']) }}
            >
                <option value="">{{ $placeholder }}</option>
                @foreach($options as $value => $label)
                    <option value="{{ $value }}" @if($value == $selected) selected @endif>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    @error($name)
        <div class="grid grid-cols-3 gap-4">
            <div></div>
            <p class="mt-1 text-sm text-red-600 col-span-2">{{ $message }}</p>
        </div>
    @enderror
</div>
