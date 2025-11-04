<button {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 rounded-lg font-semibold text-xs text-white uppercase tracking-widest  focus:outline-none focus:ring focus:ring-orange-600 focus:ring-offset transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>

