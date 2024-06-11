@props(['href'])

@php
    $classes = (request()->is(ltrim($href, '/')) || request()->fullUrlIs(url($href))) 
                ? 'text-blue-700 text-xl' 
                : 'text-gray-800 hover: hover:text-blue-700';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes . ' rounded-md px-3 py-2 text-sm font-medium']) }} aria-current="{{ request()->is(ltrim($href, '/')) ? 'page' : 'false' }}">
    {{ $slot }}
</a>
