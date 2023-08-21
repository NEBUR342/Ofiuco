<div @class([
    'text-white' => auth()->check() && auth()->user()->temaoscuro,
    'text-gray-700' => auth()->guest() || !auth()->user()->temaoscuro,
])>
    <p class="text-xl text-center">
        No se han encontrado resultados
    </p>
    @auth
        @if (auth()->user()->temaoscuro)
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ghost-2 my-12 mx-auto" width="44" height="44"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round"
                stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M10 9h.01" />
                <path d="M14 9h.01" />
                <path
                    d="M12 3a7 7 0 0 1 7 7v1l1 0a2 2 0 1 1 0 4l-1 0v3l2 3h-10a6 6 0 0 1 -6 -5.775l0 -.226l-1 0a2 2 0 0 1 0 -4l1 0v-1a7 7 0 0 1 7 -7z" />
                <path d="M11 14h2a1 1 0 0 0 -2 0z" />
            </svg>
        @else
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ghost-2 my-12 mx-auto"
                width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M10 9h.01" />
                <path d="M14 9h.01" />
                <path
                    d="M12 3a7 7 0 0 1 7 7v1l1 0a2 2 0 1 1 0 4l-1 0v3l2 3h-10a6 6 0 0 1 -6 -5.775l0 -.226l-1 0a2 2 0 0 1 0 -4l1 0v-1a7 7 0 0 1 7 -7z" />
                <path d="M11 14h2a1 1 0 0 0 -2 0z" />
            </svg>
        @endif
    @else
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ghost-2 my-12 mx-auto" width="44"
            height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round"
            stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M10 9h.01" />
            <path d="M14 9h.01" />
            <path
                d="M12 3a7 7 0 0 1 7 7v1l1 0a2 2 0 1 1 0 4l-1 0v3l2 3h-10a6 6 0 0 1 -6 -5.775l0 -.226l-1 0a2 2 0 0 1 0 -4l1 0v-1a7 7 0 0 1 7 -7z" />
            <path d="M11 14h2a1 1 0 0 0 -2 0z" />
        </svg>
    @endauth
</div>