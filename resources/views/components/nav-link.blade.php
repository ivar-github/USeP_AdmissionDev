
@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center p-2 text-gray-100 bg-red-900 rounded-lg dark:text-white  hover:bg-red-800 hover:text-white dark:hover:bg-gray-700 group'
            : 'flex items-center p-2 text-gray-900 rounded-lg dark:text-white  hover:bg-red-800 hover:text-white dark:hover:bg-gray-700 group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} >
    {{$slot}}
</a>


