<div class="min-[480px]:px-12 my-4">
    <div class="flex mb-3">
        <div class="flex-1">
            <x-input class="w-full" type='search' placeholder="Buscar publicaciones..." wire:model="buscar"></x-input>
        </div>
        <div>
            @livewire('create-community')
        </div>
    </div>
    @if ($comunidades->count())
        <div class="font-bold text-xl text-center">
            <span class="mx-3 cursor-pointer" wire:click="ordenar('nombre')" title="ORDENAR POR TITULO">
                <i class="fa-solid fa-arrow-down-a-z"></i>
            </span>
            <span class="mx-3 cursor-pointer" wire:click="ordenar('id')" title="ORDENAR POR ANTIGUEDAD">
                <i class="fa-regular fa-clock"></i>
            </span>
        </div>
        @foreach ($comunidades as $comunidad)
            <div class="my-5 bg-gray-200 rounded-lg text-center">
                <div wire:click="verComunidad({{ $comunidad->id }})"
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
                            {{ $comunidad->nombre }}
                        </p>
                        <img src="{{ Storage::url($comunidad->imagen) }}"
                            alt="imagen de la comunidad {{ $comunidad->nombre }}" class="rounded-lg mx-auto">
                        @if ($comunidad->users->count())
                            <i class="fa-solid fa-people-line bg-blue-300 px-2 py-1 rounded-lg mt-5 ml-2">
                                <span class="mx-1">
                                    {{ $comunidad->users->count() }}
                                </span>
                            </i>
                        @else
                            <i class="fa-solid fa-people-line bg-blue-300 px-2 py-1 rounded-lg mt-5 ml-2"></i>
                        @endif

                    </div>
                </div>
            </div>
        @endforeach
        {{ $comunidades->links() }}
    @else
        <x-miscomponentes.sinresultados></x-miscomponentes.sinresultados>
    @endif
</div>
