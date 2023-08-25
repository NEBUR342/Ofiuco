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
        <div class="flex flex-wrap w-5/6 min-[640px]:w-4/6 min-[760px]:w-2/6 mt-4 mx-auto text-xl">
            <span class="flex flex-col mx-auto cursor-pointer">
                <i class="fa-brands fa-tiktok"></i>
            </span>
            <span class="flex flex-col mx-auto cursor-pointer">
                <i class="fa-brands fa-twitter"></i>
            </span>
            <span class="flex flex-col mx-auto cursor-pointer">
                <i class="fa-brands fa-instagram"></i>
            </span>
            <span class="flex flex-col mx-auto cursor-pointer">
                <i class="fa-brands fa-facebook"></i>
            </span>
            <span class="flex flex-col mx-auto cursor-pointer">
                <i class="fa-brands fa-reddit"></i>
            </span>
        </div>
    </div>
</x-app-layout>
