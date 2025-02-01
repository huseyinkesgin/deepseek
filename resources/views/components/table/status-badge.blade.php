@props(['value'])

@php
$classes = $value ? 'text-green-500 bg-green-100' : 'text-red-500 bg-red-100';
$text = $value ? 'AKTİF' : 'PASİF';
@endphp

<span class="px-2 py-1 text-xs font-medium {{ $classes }} rounded-full">
    {{ $text }}
</span> 