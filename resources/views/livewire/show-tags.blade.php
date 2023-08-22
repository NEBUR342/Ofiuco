<div class="min-[480px]:px-12 my-4 cursor-default">
    <div class="flex mb-3">
        <div class="flex-1">
            <x-input class="w-full" type='search' placeholder="Buscar etiquetas..." wire:model="buscar"></x-input>
        </div>
        <div>
            @livewire('create-tags')
        </div>
    </div>
    @if ($tags->count())
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
        </div>
        @foreach ($tags as $tag)
            <div class="relative overflow-x-auto shadow-md rounded-lg my-3 mx-5" style="background:{{ $tag->color }}">
                <div class="my-3">
                    <span class="mx-3 px-2 text-xl text-gray-700 rounded-xl bg-gray-100">
                        {{ $tag->nombre }}
                    </span>
                </div>
                <div>
                    <span class="mx-3 mt-1 px-2 text-l rounded-xl bg-gray-100">
                        {{ $tag->descripcion }}
                    </span>
                </div>
                <div class="flex flex-row-reverse mx-6 my-4 ">
                    <button wire:click="borrarEtiqueta({{ $tag }})"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fa-regular fa-trash-can cursor-pointer"></i>
                    </button>
                    <button wire:click="editar({{ $tag->id }})"
                        class="mx-5 bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </button>
                </div>
            </div>
        @endforeach
        {{$tags->links()}}
    @else
        <x-miscomponentes.sinresultados></x-miscomponentes.sinresultados>
    @endif
    <!--Modal para editar-->
    @if ($miTag)
        <x-dialog-modal wire:model="openEditar">
            <x-slot name="title">
                <p class="text-white">EDITAR ETIQUETA</p>
            </x-slot>
            <x-slot name="content">
                @wire($miTag, 'defer')
                    <x-form-input name="miTag.nombre" label="Nombre de la etiqueta" />
                    <x-form-textarea name="miTag.descripcion" label="Descripcion de la etiqueta" />
                    <x-form-input name="miTag.color" type="color" label="Color" />
                @endwire
            </x-slot>
            <x-slot name="footer">
                <div class="flex flex-row-reverse">
                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                        wire:click="$set('openEditar', false)">
                        <i class="fas fa-xmark mr-2"></i>Cancelar
                    </button>
                    <button class="mr-4 bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded"
                        wire:click="update" wire:loading.attr="disabled">
                        <i class="fas fa-save mr-2"></i>Editar
                    </button>
                </div>
            </x-slot>
        </x-dialog-modal>
    @endif
</div>
