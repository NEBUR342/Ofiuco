<x-app-layout>
    <div class="max-[640px]:mx-5 min-[640px]:px-12 my-4">
        <form action="{{ route('contactanos.procesar') }}" method="POST">
            @csrf
            <x-form-input name="nombre" label="Nombre del Contacto" placeholder="Nombre del remitente..." />
            @auth
                @bind(auth()->user())
                    <x-form-input name="email" label="Email de Contacto" readonly />
                @endbind
            @else
                <x-form-input name="email" label="Email de Contacto" placeholder="Email del remitente..." />
            @endauth
            <x-form-textarea name="contenido" rows="4" placeholder="Mensaje del remitente..." label="Contenido" />
            <div class="flex flex-row-reverse mt-3">
                <button type="submit"
                    class="bg-blue-500 ml-2 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-paper-plane"></i> Enviar
                </button>
                <a href="/" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-backward"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
