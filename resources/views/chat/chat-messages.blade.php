@extends('components.miscomponentes.baseChat')
@section('contenido')
    <div>
        @if ($friends->count() || $myCommunities->count() || $communitiesParticipante->count())
            <div class="flex">
                <input style="visibility: hidden" type="checkbox" id="drawer-toggle" class="relative sr-only peer">
                <div
                    class="fixed top-40 left-0 inline-block px-2 py-3 transition-all duration-500 bg-indigo-500 rounded-lg peer-checked:rotate-180 peer-checked:left-64">
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
                    <div class="px-6 py-4 justify-center">
                        <ul role="list" class="max-w-sm divide-y divide-gray-200">
                            @if ($friends->count())
                                <h2 class="text-lg font-semibold text-center">CONTACTOS</h2>
                                <li class="py-3 sm:py-4">
                                    @foreach ($friends as $friend)
                                        <a href="{{ route('chat.index', ['tipo' => '1', 'tipoid' => $friend->user_id]) }}"
                                            class="flex items-center space-x-3 relative mb-5">
                                            <div class="flex-shrink-0">
                                                <img class="w-8 h-8 rounded-full"
                                                    src="{{ $friend->user->profile_photo_url }}"
                                                    title="{{ $friend->user->name }}" alt="{{ $friend->user->name }}">
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold truncate">
                                                    {{ $friend->user->name }}
                                                </p>
                                                <p class="text-sm truncate">
                                                    Mostrar último mensaje del chat
                                                </p>
                                            </div>
                                            <div
                                                class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold bg-blue-300 rounded-full top-0 right-0">
                                                99
                                            </div>
                                        </a>
                                    @endforeach
                                    {{ $friends->links() }}
                                </li>
                            @endif
                            @if ($myCommunities->count())
                                <h2 class="text-lg font-semibold text-center">MIS COMUNIDADES</h2>
                                <li class="py-3 sm:py-4">
                                    @foreach ($myCommunities as $myCommunity)
                                        <a href="{{ route('chat.index', ['tipo' => '2', 'tipoid' => $myCommunity->id]) }}"
                                            class="flex items-center space-x-3 relative mb-5">
                                            <div class="flex-shrink-0">
                                                <img class="w-8 h-8 rounded-full"
                                                    src="{{ Storage::url($myCommunity->imagen) }}"
                                                    title="{{ $myCommunity->nombre }}" alt="{{ $myCommunity->nombre }}">
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold truncate">
                                                    {{ $myCommunity->nombre }}
                                                </p>
                                                <p class="text-sm truncate">
                                                    Mostrar último mensaje del chat
                                                </p>
                                            </div>
                                            <div
                                                class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold bg-blue-300 rounded-full top-0 right-0">
                                                99
                                            </div>
                                        </a>
                                    @endforeach
                                    {{ $myCommunities->links() }}
                                </li>
                            @endif
                            @if ($communitiesParticipante->count())
                                <h2 class="text-lg font-semibold text-center">COMUNIDADES</h2>
                                <li class="py-3 sm:py-4">
                                    @foreach ($communitiesParticipante as $communityParticipante)
                                        <a href="{{ route('chat.index', ['tipo' => '2', 'tipoid' => $communityParticipante->id]) }}"
                                            class="flex items-center space-x-3 relative mb-5">
                                            <div class="flex-shrink-0">
                                                <img class="w-8 h-8 rounded-full"
                                                    src="{{ Storage::url($communityParticipante->imagen) }}"
                                                    title="{{ $communityParticipante->nombre }}" alt="{{ $communityParticipante->nombre }}">
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold truncate">
                                                    {{ $communityParticipante->nombre }}
                                                </p>
                                                <p class="text-sm truncate">
                                                    Mostrar último mensaje del chat
                                                </p>
                                            </div>
                                            <div
                                                class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold bg-blue-300 rounded-full top-0 right-0">
                                                99
                                            </div>
                                        </a>
                                        
                                    @endforeach
                                    {{ $communitiesParticipante->links() }}
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        <div class="h-screen flex flex-col">
            <div class="flex-grow">
                <div class="h-16"></div>
                <div class="flex flex-wrap justify-center sm:justify-end">
                    <div id="mensajes" class="sm:w-5/6 sm:mr-6">
                    </div>
                </div>
            </div>
            <form action="{{ route('chat.store', [$tipo, $tipoid]) }}" method="POST"
                class="flex flex-wrap justify-center sm:justify-end">
                @csrf
                <div class="flex flex-wrap w-5/6">
                    <div class="relative mb-3 w-5/6 text-gray-800">
                        <x-form-input name="contenido" placeholder="Contenido..." />
                    </div>
                    <div class="my-6 w-1/6 mx-auto">
                        <button type="submit" title="ENVIAR COMENTARIO"
                            class="mx-1 text-xl w-6 text-center cursor-pointer bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white rounded">
                            <i class="fa-solid fa-right-long"></i>
                        </button>
                    </div>
                </div>
            </form>
            <div id="scroll"></div>
        </div>
    </div>
    <script>
        function getMessages() {
            $.ajax({
                url: "{{ route('chat.abrirChat', ['tipo' => $tipo, 'tipoid' => $tipoid]) }}",
                type: 'GET',
                success: function(mensajes) {
                    var refrescarChat = document.getElementById("mensajes");
                    refrescarChat.innerHTML = mensajes;
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', status, error);
                }
            });
        }
        setInterval(getMessages, 5000);
        getMessages();
    </script>
    <script>
        var scroll = document.createElement("a");
        scroll.href = "#scroll";
        scroll.click();
    </script>
@endsection
