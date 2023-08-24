<div @class([
    'min-[480px]:px-12 cursor-default',
    'bg-gray-800' => auth()->check() && auth()->user()->temaoscuro,
    'bg-white' => auth()->guest() || !auth()->user()->temaoscuro,
])>
    @if ($publicaciones->count())
        @foreach ($publicaciones as $publicacion)
            <div @class([
                'mb-5 rounded-lg text-center',
                'bg-gray-700' => auth()->check() && auth()->user()->temaoscuro,
                'bg-gray-200' => auth()->guest() || !auth()->user()->temaoscuro,
            ])>
                <div wire:click="verPublicacion({{ $publicacion->id }})" @class([
                    'cursor-pointer group relative px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10',
                    'bg-gray-600' => auth()->check() && auth()->user()->temaoscuro,
                    'bg-white' => auth()->guest() || !auth()->user()->temaoscuro,
                ])>
                    <div
                        class="absolute bottom-0 left-0 h-1 w-full origin-left scale-x-0 transform bg-sky-400 duration-300 group-hover:scale-x-100">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 h-full w-1 origin-bottom scale-y-0 transform bg-sky-400 duration-300 group-hover:scale-y-100">
                    </div>
                    <div
                        class="absolute top-0 left-0 h-1 w-full origin-right scale-x-0 transform bg-sky-400 duration-300 group-hover:scale-x-100">
                    </div>
                    <div
                        class="absolute bottom-0 right-0 h-full w-1 origin-top scale-y-0 transform bg-sky-400 duration-300 group-hover:scale-y-100">
                    </div>
                    <div @class([
                        'text-white' => auth()->check() && auth()->user()->temaoscuro,
                    ])>
                        <p class="text-xl mb-5">
                            {{ $publicacion->titulo }}
                        </p>
                        <img src="{{ Storage::url($publicacion->imagen) }}" alt="imagen de {{ $publicacion->user->name }}"
                            class="rounded-lg mx-auto">
                        @auth
                            @if ($publicacion->likes->where('user_id', auth()->id())->count())
                                <i @class([
                                    'fa-solid fa-heart px-2 py-1 rounded-lg mt-5 ml-2',
                                    'bg-red-500' => auth()->user()->temaoscuro,
                                    'bg-red-200' => !auth()->user()->temaoscuro,
                                ])>
                                    <span class="mx-1">
                                        {{ $publicacion->likes->count() }}
                                    </span>
                                </i>
                            @else
                                <i @class([
                                    'fa-regular fa-heart px-2 py-1 rounded-lg mt-5 ml-2',
                                    'bg-red-500' => auth()->user()->temaoscuro,
                                    'bg-red-200' => !auth()->user()->temaoscuro,
                                ])>
                                    <span class="mx-1">
                                        {{ $publicacion->likes->count() }}
                                    </span>
                                </i>
                            @endif
                        @else
                            <i class='fa-regular fa-heart px-2 py-1 rounded-lg mt-5 ml-2 bg-red-200'>
                                <span class="mx-1">
                                    {{ $publicacion->likes->count() }}
                                </span>
                            </i>
                        @endauth
                        @if ($publicacion->comments->count())
                            <i @class([
                                'fa-solid fa-message px-2 py-1 rounded-lg mt-5 ml-2',
                                'bg-blue-600' => auth()->check() && auth()->user()->temaoscuro,
                                'bg-blue-300' => auth()->guest() || !auth()->user()->temaoscuro,
                            ])>
                                <span class="mx-1">
                                    {{ $publicacion->comments->count() }}
                                </span>
                            </i>
                        @else
                            <i @class([
                                'fa-regular fa-message px-2 py-1 rounded-lg mt-5 ml-2',
                                'bg-blue-600' => auth()->check() && auth()->user()->temaoscuro,
                                'bg-blue-300' => auth()->guest() || !auth()->user()->temaoscuro,
                            ])></i>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        {{ $publicaciones->links() }}
    @else
        <x-miscomponentes.sinresultados></x-miscomponentes.sinresultados>
    @endif
</div>
