<div class="min-[480px]:px-12 my-4 cursor-default">
    <div class="flex mb-3">
        <div class="flex-1">
            <x-input class="w-full text-gray-800" type='search' placeholder="Buscar usuario..."
                wire:model="buscar"></x-input>
        </div>
    </div>
    @if ($solicitudes->count())
        <div @class([
            'font-bold text-xl text-center my-4',
            'text-white' => auth()->user()->temaoscuro,
        ])>
            <span class="mx-3 cursor-pointer" wire:click="ordenar('nombre')" title="ORDENAR POR NOMBRE">
                <i class="fa-solid fa-arrow-down-a-z"></i>
            </span>
            <span class="mx-3 cursor-pointer" wire:click="ordenar('creacion')" title="ORDENAR POR ANTIGUEDAD">
                <i class="fa-regular fa-clock"></i>
            </span>
        </div>
        @foreach ($solicitudes as $solicitud)
            <div @class([
                'relative overflow-x-auto shadow-md rounded-lg my-3 mx-5',
                'bg-gray-700 hover:bg-gray-600 text-white' => auth()->user()->temaoscuro,
                'bg-gray-200 hover:bg-gray-100' => !auth()->user()->temaoscuro,
            ])>
                <div class="flex flex-wrap my-3">
                    <span class="flex flex-col">
                        <img class="h-8 w-8 rounded-full ml-4 cursor-pointer"
                            src="{{ $solicitud->user->profile_photo_url }}"
                            wire:click="buscarUsuario({{ $solicitud->user->id }})"
                            title="Publicaciones de {{ $solicitud->user->name }}" alt="{{ $solicitud->user->name }}" />
                    </span>
                    <span @class([
                        'flex flex-col mx-3 px-2 text-xl rounded-xl',
                        'text-gray-700' => !auth()->user()->temaoscuro,
                    ])>
                        {{ $solicitud->user->name }}
                    </span>
                </div>
                <div>
                    <span class="mx-3 px-2 text-l rounded-xl">
                        {{ $solicitud->user->email }}
                    </span>
                </div>

                <div class="flex flex-row-reverse my-4 mr-2">
                    @if (auth()->user()->is_admin)
                        <span class="mx-2">
                            <i class="fa-regular fa-bookmark cursor-pointer text-yellow-500"
                                wire:click="buscarSavesUsuario({{ $solicitud->user->id }})"></i>
                        </span>
                    @endif
                    <span class="mx-2">
                        <i class="fa-regular fa-heart cursor-pointer text-red-500"
                            wire:click="buscarLikesUsuario({{ $solicitud->user->id }})"></i>
                    </span>
                    <span class="mx-2">
                        <i class="fa-solid fa-user-minus cursor-pointer text-red-500"
                            wire:click="borrarsolicitudamigo({{ $solicitud->user->id }})"></i>
                    </span>
                    <span class="mx-2">
                        <i class="fa-solid fa-user-plus cursor-pointer text-blue-500"
                            wire:click="solicitudamigo({{ $solicitud->id }})"></i>
                    </span>
                </div>
            </div>
        @endforeach
        {{ $solicitudes->links() }}
    @else
        <x-miscomponentes.sinresultados></x-miscomponentes.sinresultados>
    @endif
</div>
