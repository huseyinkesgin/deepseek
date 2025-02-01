<button {{ $attributes->merge(['type' => 'button', 'class' =>
'inline-flex items-center px-2 py-1 bg-amber-700 border border-gray-300 font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
