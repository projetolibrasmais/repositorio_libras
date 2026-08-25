@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-logo-sky focus:ring-logo-sky rounded-md shadow-sm']) }}>
