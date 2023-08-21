
@php
    if (auth()->user()) {
        if (auth()->user()->temaoscuro) {
            $classes = 'block w-full px-4 py-2 text-left text-sm leading-5 bg-gray-700 text-gray-200 hover:bg-gray-800 focus:outline-none focus:bg-gray-800 transition duration-150 ease-in-out' ;
        } else {
            $classes = 'block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out' ;
        }
    } else {
        $classes = 'block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out' ;
    }
@endphp
<a {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>