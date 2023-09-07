<div class="min-[480px]:px-12 my-4 cursor-default">
    @if ($solicitudes->count())
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
                            title="Publicaciones de {{ $solicitud->user->name }}"
                            alt="{{ $solicitud->user->name }}" />
                    </span>
                    <span @class([
                        'flex flex-col mx-3 px-2 text-xl rounded-xl',
                        'text-gray-700' => !auth()->user()->temaoscuro,
                    ])>
                        {{ $solicitud->user->name }}
                    </span>
                </div>
                <div class="my-5 mx-5">
                    <span class="mb-2">
                        Quiere participar en tu comunidad
                    </span>
                    <span @class([
                        'rounded-xl cursor-pointer',
                        'bg-gray-500 py-1 px-2' => auth()->check() && auth()->user()->temaoscuro,
                        'bg-gray-400 py-1 px-2' => auth()->guest() || !auth()->user()->temaoscuro,
                    ])
                        wire:click="verComunidad({{ $solicitud->community_id }})">{{ $solicitud->community->nombre }}
                    </span>
                    <div class="mt-2">
                        {{$solicitud->created_at->format('d/m/Y H:i')}}
                    </div>
                </div>
                <div class="flex flex-row-reverse my-4">
                    <span class="mx-4">
                        <i class="fa-regular fa-bookmark cursor-pointer text-yellow-500" wire:click="rechazarUsuario({{ $solicitud }})"></i>
                    </span>
                    <span>
                        <i class="fa-regular fa-heart cursor-pointer text-red-500" wire:click="aceptarUsuario({{ $solicitud }})"></i>
                    </span>
                </div>
            </div>
        @endforeach
        {{ $solicitudes->links() }}
    @else
        <x-miscomponentes.sinresultados></x-miscomponentes.sinresultados>
    @endif
</div>