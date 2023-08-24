<div class="min-[480px]:px-12 my-4 cursor-default">
    <div class="flex mb-3">
        <div class="flex-1">
            <x-input class="w-full" type='search' placeholder="Buscar usuario..." wire:model="buscar"></x-input>
        </div>
        <div>
            @livewire('create-users')
        </div>
    </div>
    @if ($users->count())
        <div @class([
            'font-bold text-xl text-center my-4',
            'text-white' => auth()->check() && auth()->user()->temaoscuro,
        ])>
            <span class="mx-3 cursor-pointer" wire:click="ordenar('nombre')" title="ORDENAR POR NOMBRE">
                <i class="fa-solid fa-arrow-down-a-z"></i>
            </span>
            <span class="mx-3 cursor-pointer" wire:click="ordenar('creacion')" title="ORDENAR POR ANTIGUEDAD">
                <i class="fa-regular fa-clock"></i>
            </span>
        </div>
        @foreach ($users as $usuario)
            <div @class([
                'relative overflow-x-auto shadow-md rounded-lg my-3 mx-5 cursor-pointer',
                'bg-gray-700 hover:bg-gray-600 text-white' =>
                    auth()->check() && auth()->user()->temaoscuro,
                'hover:bg-gray-300' => auth()->guest() || !auth()->user()->temaoscuro,
            ]) wire:click="buscarUsuario({{ $usuario->id }})"
                title="Publicaciones de {{ $usuario->name }}">
                <div class="flex flex-wrap my-3">
                    <span class="flex flex-col">
                        <img class="h-8 w-8 rounded-full ml-4" src="{{ $usuario->profile_photo_url }}"
                            alt="{{ $usuario->name }}" />
                    </span>
                    <span @class([
                        'flex flex-col mx-3 px-2 text-xl rounded-xl',
                        'text-gray-700' => auth()->guest() || !auth()->user()->temaoscuro,
                    ])>
                        {{ $usuario->name }}
                    </span>
                </div>
                <div>
                    <span class="mx-3 px-2 text-l rounded-xl">
                        {{ $usuario->email }}
                    </span>
                </div>
            </div>
        @endforeach
        {{ $users->links() }}
    @else
        <x-miscomponentes.sinresultados></x-miscomponentes.sinresultados>
    @endif
</div>
