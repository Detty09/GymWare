@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'p-1 border border-gray-700 text-white text-sm rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-orange-600']) }}>
