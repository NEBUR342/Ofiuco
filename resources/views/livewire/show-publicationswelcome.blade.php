<div class="min-[480px]:px-12 my-4">
    @if ($publicaciones->count())
        @foreach ($publicaciones as $publicacion)
            <div class="my-5 bg-gray-200 rounded-lg text-center">
                <div wire:click="verPublicacion({{ $publicacion->id }})"
                    class="cursor-pointer group relative bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10">
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
                    <div>
                        <p class="text-gray-700 text-xl mb-5">
                            {{ $publicacion->titulo }}
                        </p>
                        <img src="{{ Storage::url($publicacion->imagen) }}"
                            alt="imagen de {{ $publicacion->user->name }}" class="rounded-lg mx-auto">
                        @auth
                            @if ($publicacion->likes->where('user_id', auth()->id())->count())
                                <i class="fa-solid fa-heart bg-red-200 px-2 py-1 rounded-lg mt-5">
                                    <span class="mx-1">
                                        {{ $publicacion->likes->count() }}
                                    </span>
                                </i>
                            @else
                                <i class="fa-regular fa-heart bg-red-200 px-2 py-1 rounded-lg mt-5">
                                    <span class="mx-1">
                                        {{ $publicacion->likes->count() }}
                                    </span>
                                </i>
                            @endif
                        @else
                            <i class="fa-regular fa-heart bg-red-200 px-2 py-1 rounded-lg mt-5">
                                <span class="mx-1">
                                    {{ $publicacion->likes->count() }}
                                </span>
                            </i>
                        @endauth
                        @if ($publicacion->comments->count())
                            <i class="fa-solid fa-message bg-blue-300 px-2 py-1 rounded-lg mt-5 ml-2">
                                <span class="mx-1">
                                    {{ $publicacion->comments->count() }}
                                </span>
                            </i>
                        @else
                            <i class="fa-regular fa-message bg-blue-300 px-2 py-1 rounded-lg mt-5 ml-2"></i>
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
