@extends('components.miscomponentes.baseChat')
@section('contenido')
        <div class="h-screen flex flex-col">
            <div class="flex-grow">
                <div class="h-16"></div>
                <div class="flex flex-wrap justify-center sm:justify-end">
                    <div id="mensajes" class="sm:w-5/6 sm:mr-6">
                    </div>
                </div>
            </div>
            @if($tipo!=0 && $tipoid!=0)
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
            @endif
            <div id="scroll"></div>
        </div>
        <div class="flex ">
            <input type="checkbox" id="drawer-toggle" class="relative sr-only peer" checked>
            <label for="drawer-toggle"
                class="fixed top-20 left-0 cursor-pointer inline-block p-4 transition-all duration-500 bg-indigo-500 rounded-lg peer-checked:rotate-180 peer-checked:left-64">
                <div class="w-6 h-1 mb-3 -rotate-45 bg-white rounded-lg"></div>
                <div class="w-6 h-1 rotate-45 bg-white rounded-lg"></div>
            </label>
            <div @class([
                'fixed top-0 left-0 w-64 h-full transition-all duration-500 transform -translate-x-full shadow-lg peer-checked:translate-x-0',
                'bg-gray-700 text-white' => auth()->check() && auth()->user()->temaoscuro,
                'bg-gray-200' => auth()->guest() || !auth()->user()->temaoscuro,
            ])>
            <div class="h-16"></div>
                <div class="px-6 py-4 justify-center" id="contactos">
                </div>
            </div>
        </div>
        
    <script>
        function getMessages() {
            $.ajax({
                url: "{{ route('chat.abrirChat', ['tipo' => $tipo, 'tipoid' => $tipoid]) }}",
                type: 'GET',
                success: function(mensajes) {
                    var refrescarChat = document.getElementById("mensajes");
                    refrescarChat.innerHTML = mensajes[0];
                    var refrescarContactos = document.getElementById("contactos");
                    refrescarContactos.innerHTML = mensajes[1];
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
