@extends('components.miscomponentes.baseChat')
@section('contenido')
    <div>
        <div class="h-16"></div>
        @if ($friends->count() || $myCommunities->count() || $communitiesParticipante->count())
            <div class="flex">
                <input style="visibility: hidden" type="checkbox" id="drawer-toggle" class="relative sr-only peer" checked>
                <div
                    class="fixed top-20 left-0 inline-block px-2 py-3 transition-all duration-500 bg-indigo-500 rounded-lg peer-checked:rotate-180 peer-checked:left-64">
                    <label for="drawer-toggle" class="cursor-pointer">
                        <div class="w-6 h-1 mb-3 -rotate-45 bg-white rounded-lg"></div>
                        <div class="w-6 h-1 rotate-45 bg-white rounded-lg"></div>
                    </label>
                </div>
                <div @class([
                    'fixed top-0 left-0 z-20 w-64 h-full transition-all duration-500 transform -translate-x-full shadow-lg peer-checked:translate-x-0',
                    'bg-gray-700 text-white' => auth()->check() && auth()->user()->temaoscuro,
                    'bg-gray-200' => auth()->guest() || !auth()->user()->temaoscuro,
                ])>
                    <div class="px-6 py-4 text-center justify-center">
                        @if ($friends->count())
                            <h2 class="text-lg font-semibold">CONTACTOS</h2>
                            @foreach ($friends as $friend)
                                <a href="{{ route('chat.index', ['tipo' => '1', 'tipoid' => $friend->id]) }}"
                                    class="flex flex-col w-8 items-center my-2 mx-auto">
                                    <img class="flex h-8 w-8 rounded-full ml-4" src="{{ $friend->user->profile_photo_url }}"
                                        title="{{ $friend->user->name }}" alt="{{ $friend->user->name }}" />
                                </a>
                            @endforeach
                            {{ $friends->links() }}
                        @endif
                        @if ($myCommunities->count())
                            <h2 class="text-lg font-semibold">MIS COMUNIDADES</h2>
                            @foreach ($myCommunities as $myCommunity)
                                <a href="{{ route('chat.index', ['tipo' => '2', 'tipoid' => $myCommunity->id]) }}"
                                    class="flex flex-col w-8 items-center my-2 mx-auto">
                                    <img class="flex h-8 w-8 rounded-full ml-4"
                                        src="{{ Storage::url($myCommunity->imagen) }}" title="{{ $myCommunity->nombre }}"
                                        alt="{{ $myCommunity->nombre }}" />
                                </a>
                            @endforeach
                            {{ $myCommunities->links() }}
                        @endif
                        @if ($communitiesParticipante->count())
                            <h2 class="text-lg font-semibold">COMUNIDADES</h2>
                            @foreach ($communitiesParticipante as $communityParticipante)
                                <a href="{{ route('chat.index', ['tipo' => '2', 'tipoid' => $communityParticipante->id]) }}"
                                    class="flex flex-col w-8 items-center my-2 mx-auto">
                                    <img class="flex h-8 w-8 rounded-full ml-4"
                                        src="{{ Storage::url($communityParticipante->imagen) }}"
                                        title="{{ $communityParticipante->nombre }}"
                                        alt="{{ $communityParticipante->nombre }}" />
                                </a>
                            @endforeach
                            {{ $communitiesParticipante->links() }}
                        @endif
                    </div>
                </div>
            </div>
        @endif
        <div>
            <div id="mensajes">
                @if ($mensajes->count())
                    @foreach ($mensajes as $mensaje)
                        <div class='text-center'>{{ $mensaje->contenido }}</div>
                    @endforeach
                @else
                    <p>SE EL PRIMERO EN MANDAR UN MENSAJE</p>
                    <img src="{{ Storage::url('logochat.png') }}" class="h-96 mx-auto" alt="logo Ofiuco">
                @endif
            </div>
        </div>
            <a id="refrescarChat" href=""></a>
        </div>
        <script>
            var scroll = document.createElement("a");
            scroll.href = "#footer";
            scroll.click();
        
            function getMessages() {
                $.ajax({
                    url: "{{ route('chat.abrirChat', ['tipo' => $tipo, 'tipoid' => $tipoid]) }}",
                    type: 'GET',
                    success: function(data) {
                        var mensajes = data.mensajes;
                        console.log(data['mensajes']['data'])
                        $('#mensajes').html(data[0]);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud AJAX:', status, error);
                    }
                });
            }
            setInterval(getMessages, 5000);
        </script>

@endsection
