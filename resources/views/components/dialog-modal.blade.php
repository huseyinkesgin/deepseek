@props(['id' => null, 'maxWidth' => null, 'focusInput' => null])

<x-modal maxWidth="{{ $maxWidth }}" {{ $attributes }}>
    <div class="px-6 py-4">
        <div class="text-lg font-medium">
            {{ $title }}
        </div>

        <div
            x-data
            x-init="$nextTick(() => $refs['{{ $focusInput }}']?.focus())"
            class="mt-4"
        >
            {{ $content }}
        </div>
    </div>

    @if (isset($footer))
        <div class="px-6 py-4 bg-gray-100 text-right">
            {{ $footer }}
        </div>
    @endif
</x-modal>
