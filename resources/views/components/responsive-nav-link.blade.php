@props(['active'])

@php
    if (auth()->user()) {
        if (auth()->user()->temaoscuro) {
            $classes = $active ?? false 
            ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-indigo-700 text-left text-base font-medium text-white bg-gray-800 focus:outline-none focus:text-gray-100 focus:bg-indigo-800 focus:border-indigo-700 transition duration-150 ease-in-out' 
            : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-500 hover:text-gray-300 hover:bg-gray-700 hover:border-indigo-700 focus:outline-none focus:text-gray-100 focus:bg-indigo-800 focus:border-indigo-700 transition duration-150 ease-in-out';
        } else {
            $classes = $active ?? false 
            ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-left text-base font-medium text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out' 
            : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out';
        }
    } else {
        $classes = $active ?? false 
        ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-left text-base font-medium text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out' 
        : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out';
    }
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
