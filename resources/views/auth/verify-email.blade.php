<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>
        <div class="mb-4 text-sm text-gray-600 text-center">
            {{ __('SE HA MANDADO UN CORREO DE VERIFICACION A TU GMAIL, POR FAVOR REVISA SI SE ENCUENTRA EN SPAM') }}
        </div>
        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('SE ENVIÓ UN NUEVO ENLACE DE VERIFICACIÓN A LA DIRECCIÓN DE CORREO ELECTRÓNICO QUE PROPORCIONÓ EN LA CONFIGURACIÓN DE SU PERFIL') }}
            </div>
        @endif
        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <div>
                    <x-button type="submit">
                        {{ __('REENVIAR VERIFICACION DE EMAIL') }}
                    </x-button>
                </div>
            </form>
            <div class="ml-2">
                <a href="{{ route('profile.show') }}"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('EDITAR PERFIL') }}</a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ml-2">
                        {{ __('LOG OUT') }}
                    </button>
                </form>
            </div>
        </div>
    </x-authentication-card>
</x-guest-layout>
