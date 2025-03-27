
@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center p-1 text-gray-700 rounded-md border-b-2 border-red-800  dark:text-white  dark:border-red-400  group'
            : 'flex items-center p-1 text-gray-900 rounded-md dark:text-white border-b-2 border-slate-100 hover:border-slate-200 dark:border-transparent dark:hover:border-slate-700 group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} >
    {{$slot}}
</a>


