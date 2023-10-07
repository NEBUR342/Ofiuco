<div class='min-[480px]:px-12 mt-4 cursor-default'>
    <div class="h-16"></div>
    <div class="flex mb-3">
        <div class="flex-1">
            <x-input class="w-full text-gray-800" type='search' placeholder="Buscar comunidades..."
                wire:model="buscar"></x-input>
        </div>
        <div>
            @livewire('create-community')
        </div>
    </div>
    <div @class([
        'font-bold text-xl text-center my-4',
        'text-white' => auth()->check() && auth()->user()->temaoscuro,
    ])>
        <span class="mx-3 cursor-pointer" wire:click="ordenar('nombre')" title="ORDENAR POR TITULO">
            <i class="fa-solid fa-arrow-down-a-z"></i>
        </span>
        <span class="mx-3 cursor-pointer" wire:click="ordenar('creacion')" title="ORDENAR POR ANTIGUEDAD">
            <i class="fa-regular fa-clock"></i>
        </span>
        <span class="mx-3 cursor-pointer ml-6 text-blue-500" wire:click="diferenciar(1)" title="MOSTRAR TODAS">
            <i class="fa-solid fa-users-between-lines"></i>
        </span>
        <span class="mx-3 cursor-pointer text-blue-500" wire:click="diferenciar(2)" title="MOSTRAR CREADAS">
            <i class="fa-solid fa-users-viewfinder"></i>
        </span>
        <span class="mx-3 cursor-pointer text-blue-500" wire:click="diferenciar(3)" title="MOSTRAR PARTICIPADAS">
            <i class="fa-solid fa-users-rays"></i>
        </span>
    </div>
    @if ($comunidades->count())
        @foreach ($comunidades as $comunidad)
            <div @class([
                'mb-5 rounded-lg text-center',
                'bg-gray-700' => auth()->user()->temaoscuro,
                'bg-gray-200' => !auth()->user()->temaoscuro,
            ])>
                <div wire:click="verComunidad({{ $comunidad->id }})" @class([
                    'cursor-pointer group relative px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10',
                    'bg-gray-600' => auth()->user()->temaoscuro,
                    'bg-white' => !auth()->user()->temaoscuro,
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
                        'text-white' => auth()->user()->temaoscuro,
                    ])>
                        <p class="text-xl mb-5">
                            {{ $comunidad->nombre }}
                        </p>
                        <img src="{{ Storage::url($comunidad->imagen) }}"
                            alt="imagen de la comunidad {{ $comunidad->nombre }}" class="rounded-lg mx-auto">
                        @if ($comunidad->users->count())
                            <i @class([
                                'fa-solid fa-people-line px-2 py-1 rounded-lg mt-5 ml-2',
                                'bg-blue-600' => auth()->user()->temaoscuro,
                                'bg-blue-300' => !auth()->user()->temaoscuro,
                            ])>
                                <span class="mx-1">
                                    {{ $comunidad->users->count() }}
                                </span>
                            </i>
                        @else
                            <i @class([
                                'fa-solid fa-people-line px-2 py-1 rounded-lg mt-5 ml-2',
                                'bg-blue-600' => auth()->user()->temaoscuro,
                                'bg-blue-300' => !auth()->user()->temaoscuro,
                            ])></i>
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
