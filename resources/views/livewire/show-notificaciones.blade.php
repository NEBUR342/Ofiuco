<div class="min-[480px]:px-12 my-4 cursor-default">
    @if ($notificaciones->count())
        @foreach ($notificaciones as $notificacion)
            <div @class([
                'relative overflow-x-auto shadow-md rounded-lg my-3 mx-5',
                'bg-gray-700 hover:bg-gray-600 text-white' => auth()->user()->temaoscuro,
                'bg-gray-200 hover:bg-gray-100' => !auth()->user()->temaoscuro,
            ])>
                <div class="flex flex-wrap my-3">
                    <span class="flex flex-col">
                        <img class="h-8 w-8 rounded-full ml-4 cursor-pointer"
                            src="{{ $notificacion->user->profile_photo_url }}"
                            wire:click="buscarUsuario({{ $notificacion->user->id }})"
                            title="Publicaciones de {{ $notificacion->user->name }}"
                            alt="{{ $notificacion->user->name }}" />
                    </span>
                    <span @class([
                        'flex flex-col mx-3 px-2 text-xl rounded-xl',
                        'text-gray-700' => !auth()->user()->temaoscuro,
                    ])>
                        {{ $notificacion->user->name }}
                    </span>
                </div>
                <div class="my-5 mx-5">
                    <div class="mb-2">
                        {{ $mensaje }}
                    </div>
                    <span @class([
                        'rounded-xl cursor-pointer',
                        'bg-gray-500 py-1 px-2' => auth()->check() && auth()->user()->temaoscuro,
                        'bg-gray-400 py-1 px-2' => auth()->guest() || !auth()->user()->temaoscuro,
                    ])
                        wire:click="verPublicacion({{ $notificacion->publication->id }})">{{ $notificacion->publication->titulo }}

                    </span>
                    <div class="mt-2">
                        {{$notificacion->created_at->format('d/m/Y H:i')}}
                    </div>
                </div>
            </div>
        @endforeach
        {{ $notificaciones->links() }}
    @else
        <x-miscomponentes.sinresultados></x-miscomponentes.sinresultados>
    @endif
</div>
