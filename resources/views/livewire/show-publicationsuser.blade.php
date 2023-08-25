<div class='min-[480px]:px-12 mt-4 cursor-default'>
    <div class="flex mb-3">
        <div class="flex-1">
            <x-input class="w-full" type='search' placeholder="Buscar publicaciones..." wire:model="buscar"></x-input>
        </div>
        <div>
            @livewire('create-publication')
        </div>
    </div>
    @if ($publicaciones->count())
        <div @class([
            'font-bold text-xl text-center mt-4',
            'text-white' => auth()->user()->temaoscuro,
        ])>
            <span class="mx-3 cursor-pointer" wire:click="ordenar('titulo')" title="ORDENAR POR TITULO"><i
                    class="fa-solid fa-arrow-down-a-z"></i></span>
            <span class="mx-3 cursor-pointer" wire:click="ordenar('comunidades')" title="ORDENAR POR COMUNIDAD"><i
                    class="fa-solid fa-users"></i></span>
            <span class="mx-3 cursor-pointer" wire:click="ordenar('likes')" title="ORDENAR POR LIKES"><i
                    class="fa-solid fa-fire"></i></span>
            <span class="mx-3 cursor-pointer" wire:click="ordenar('creacion')" title="ORDENAR POR ANTIGUEDAD"><i
                    class="fa-regular fa-clock"></i></span>
        </div>
        <div class="mt-3 flex flex-wrap justify-center text-center">
            @foreach ($publicaciones as $publicacion)
                <div wire:click="verPublicacion({{ $publicacion->id }})"
                    class="min-[480px]:rounded-lg flex flex-col w-1/3 h-1/3 min-[480px]:w-1/4 min-[480px]:m-3 border border-gray-800 cursor-pointer">
                    <img src="{{ Storage::url($publicacion->imagen) }}" alt="{{ $publicacion->titulo }}"
                        class="min-[480px]:rounded-lg">

                </div>
            @endforeach
        </div>
        {{ $publicaciones->links() }}
    @else
        <x-miscomponentes.sinresultados></x-miscomponentes.sinresultados>
    @endif
</div>
