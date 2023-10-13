<nav x-data="{ open: false }" @class([
    'border-b border-gray-100 fixed w-full z-20 top-0 left-0',
    'bg-white' => auth()->guest() || !auth()->user()->temaoscuro,
]) @style(['background-color: #041124' => auth()->check() && auth()->user()->temaoscuro])>
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('inicio') }}" title="PUBLICACIONES">
                        <x-application-mark />
                    </a>
                </div>
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" title="PUBLICACIONES DE COMUNIDADES">
                            <i class="fa-solid fa-house"></i>
                        </x-nav-link>
                        <x-nav-link :href="route('communities.show')" :active="request()->routeIs('communities.show')" title="COMUNIDADES">
                            <i class="fa-solid fa-people-roof"></i>
                        </x-nav-link>
                        <x-nav-link :href="route('perfiluser.show', ['id' => auth()->user()->id])" :active="request()->routeIs('perfiluser.show', ['id' => auth()->user()->id])" title="MIS PUBLICACIONES">
                            <i class="fa-solid fa-person-shelter"></i>
                        </x-nav-link>
                        @if (auth()->user()->is_admin)
                            <x-nav-link :href="route('tags.show')" :active="request()->routeIs('tags.show')" title="TAGS">
                                <i class="fa-solid fa-tags"></i>
                            </x-nav-link>
                        @endif
                        <x-nav-link :href="route('users.show')" :active="request()->routeIs('users.show')" title="USUARIOS">
                            <i class="fa-solid fa-users"></i>
                        </x-nav-link>
                        {{-- Notificaciones --}}
                        @auth
                            <div @class([
                                'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-300 hover:border-gray-100 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out' => auth()->user()->temaoscuro,
                                'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out' => !auth()->user()->temaoscuro,
                            ])>
                                <x-dropdown width="48">
                                    <x-slot name="trigger">
                                        <i class="fa-regular fa-bell cursor-pointer" title="NOTIFICACIONES"></i>
                                    </x-slot>
                                    <x-slot name="content">
                                        {{-- Likes --}}
                                        <x-dropdown-link href="{{ route('notificaciones.show', ['id' => '1']) }}">
                                            <i class="fa-regular fa-heart"></i> Likes
                                        </x-dropdown-link>
                                        <div class="border-t border-gray-200"></div>
                                        {{-- Guardados --}}
                                        <x-dropdown-link href="{{ route('notificaciones.show', ['id' => '2']) }}">
                                            <i class="fa-regular fa-floppy-disk"></i> Guardados
                                        </x-dropdown-link>
                                        <div class="border-t border-gray-200"></div>
                                        {{-- comentarios --}}
                                        <x-dropdown-link href="{{ route('notificaciones.show', ['id' => '3']) }}">
                                            <i class="fa-regular fa-message"></i> Comentarios
                                        </x-dropdown-link>
                                        <div class="border-t border-gray-200"></div>
                                        {{-- solicitudes --}}
                                        <x-dropdown-link href="{{ route('solicitudes.show') }}">
                                            <i class="fa-solid fa-users-gear"></i> Comunidades
                                        </x-dropdown-link>
                                        <div class="border-t border-gray-200"></div>
                                        {{-- Amigos --}}
                                        <x-dropdown-link href="{{ route('solicitudesamigos.show') }}">
                                            <i class="fa-solid fa-user-group"></i> Amigos
                                        </x-dropdown-link>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        @endauth
                        {{-- Chat parte de investigacion --}}
                        <x-nav-link :href="route('messages.show')" :active="request()->routeIs('messages.show')" title="CHAT">
                            <i class="fa-regular fa-comment-dots"></i>
                        </x-nav-link>
                    @endauth
                    <x-nav-link :href="route('contactanos.pintar')" :active="request()->routeIs('contactanos.pintar')" title="CONTACTANOS">
                        <i class="fa-regular fa-envelope"></i>
                    </x-nav-link>
                </div>
            </div>
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <div class="ml-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button
                                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover"
                                            src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            {{ Auth::user()->name }}
                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            </x-slot>
                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                </div>
                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    <i class="fa-solid fa-user-gear"></i> {{ __('Profile') }}
                                </x-dropdown-link>
                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                        {{ __('API Tokens') }}
                                    </x-dropdown-link>
                                @endif
                                <div class="border-t border-gray-200"></div>
                                <!-- Amigos -->
                                <x-dropdown-link
                                    href="{{ route('friends.show') }}">
                                    <i class="fa-solid fa-user-group"></i> Amigos
                                </x-dropdown-link>
                                <div class="border-t border-gray-200"></div>
                                <!-- Tema oscuro -->
                                <x-dropdown-link href="{{ route('temaoscuro.cambiartema') }}"
                                    active="request()->routeIs('temaoscuro.cambiartema')">
                                    @if (auth()->user()->temaoscuro)
                                        <i class="fa-regular fa-moon"></i> Modo oscuro
                                    @else
                                        <i class="fa-regular fa-sun"></i> Modo claro
                                    @endif
                                </x-dropdown-link>
                                <div class="border-t border-gray-200"></div>
                                <!-- Likes -->
                                <x-dropdown-link
                                    href="{{ route('publicationslikes.show', ['id' => auth()->user()->id]) }}">
                                    <i class="fa-regular fa-heart"></i> Likes
                                </x-dropdown-link>
                                <div class="border-t border-gray-200"></div>
                                <!-- Guardados -->
                                <x-dropdown-link
                                    href="{{ route('publicationssaves.show', ['id' => auth()->user()->id]) }}">
                                    <i class="fa-regular fa-floppy-disk"></i> Guardados
                                </x-dropdown-link>
                                <div class="border-t border-gray-200"></div>
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                        <i class="fa-solid fa-right-from-bracket"></i> {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    @if (Route::has('login'))
                        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                                    in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                @endauth
            </div>
            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" @class([
                    'inline-flex items-center justify-center p-2 rounded-md focus:outline-none transition duration-150 ease-in-out',
                    'text-gray-200 hover:text-gray-200 hover:bg-gray-700 focus:bg-gray-200 focus:text-gray-800' =>
                        auth()->check() && auth()->user()->temaoscuro,
                    'text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:bg-gray-100 focus:text-gray-500' =>
                        auth()->guest() || !auth()->user()->temaoscuro,
                ])>
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <i class="fa-solid fa-house"></i> PUBLICACIONES DE COMUNIDADES
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('communities.show')" :active="request()->routeIs('communities.show')">
                    <i class="fa-solid fa-people-roof"></i> COMUNIDADES
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('perfiluser.show', ['id' => auth()->user()->id])" :active="request()->routeIs('perfiluser.show', ['id' => auth()->user()->id])">
                    <i class="fa-solid fa-person-shelter"></i> MIS PUBLICACIONES
                </x-responsive-nav-link>
                @if (auth()->user()->is_admin)
                    <x-responsive-nav-link :href="route('tags.show')" :active="request()->routeIs('tags.show')">
                        <i class="fa-solid fa-tags"></i> TAGS
                    </x-responsive-nav-link>
                @endif
                <x-responsive-nav-link :href="route('users.show')" :active="request()->routeIs('users.show')">
                    <i class="fa-solid fa-users"></i> USUARIOS
                </x-responsive-nav-link>
                {{-- Notificaciones --}}
                <div @class([
                    'cursor-pointer',
                    'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-500 hover:text-gray-300 hover:bg-gray-700 hover:border-indigo-700 focus:outline-none focus:text-gray-100 focus:bg-indigo-800 focus:border-indigo-700 transition duration-150 ease-in-out' => auth()->user()->temaoscuro,
                    'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out' => !auth()->user()->temaoscuro,
                ])>
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <i class="fa-regular fa-bell"></i> NOTIFICACIONES
                        </x-slot>

                        <x-slot name="content">
                            {{-- Likes --}}
                            <x-dropdown-link href="{{ route('notificaciones.show', ['id' => '1']) }}">
                                <i class="fa-regular fa-heart"></i> Likes
                            </x-dropdown-link>
                            <div class="border-t border-gray-200"></div>
                            {{-- Guardados --}}
                            <x-dropdown-link href="{{ route('notificaciones.show', ['id' => '2']) }}">
                                <i class="fa-regular fa-floppy-disk"></i> Guardados
                            </x-dropdown-link>
                            <div class="border-t border-gray-200"></div>
                            {{-- comentarios --}}
                            <x-dropdown-link href="{{ route('notificaciones.show', ['id' => '3']) }}">
                                <i class="fa-regular fa-message"></i> Comentarios
                            </x-dropdown-link>
                            <div class="border-t border-gray-200"></div>
                            {{-- comunidades --}}
                            <x-dropdown-link href="{{ route('solicitudes.show') }}">
                                <i class="fa-solid fa-users-gear"></i> Comunidades
                            </x-dropdown-link>
                            <div class="border-t border-gray-200"></div>
                            {{-- amigos --}}
                            <x-dropdown-link href="{{ route('solicitudesamigos.show') }}">
                                <i class="fa-solid fa-user-group"></i> Amigos
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
                {{-- Chat parte de investigacion --}}
                <x-responsive-nav-link :href="route('messages.show')" :active="request()->routeIs('messages.show')">
                    <i class="fa-regular fa-comment-dots"></i> CHAT
                </x-responsive-nav-link>
            @endauth
            <x-responsive-nav-link :href="route('contactanos.pintar')" :active="request()->routeIs('contactanos.pintar')">
                <i class="fa-regular fa-envelope"></i> CONTACTANOS
            </x-responsive-nav-link>
        </div>
        <!-- Responsive Settings Options -->
        @auth
            <div class="ml-3 relative">
                <x-dropdown align="left" width="48">
                    <x-slot name="trigger">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <button
                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover"
                                    src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            </button>
                        @else
                            <span class="inline-flex rounded-md">
                                <button type="button"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                    {{ Auth::user()->name }}
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </span>
                        @endif
                    </x-slot>

                    <x-slot name="content">
                        <!-- Account Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Account') }}
                        </div>

                        <x-dropdown-link href="{{ route('profile.show') }}">
                            <i class="fa-solid fa-user-gear"></i> {{ __('Profile') }}
                        </x-dropdown-link>

                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                {{ __('API Tokens') }}
                            </x-dropdown-link>
                        @endif

                        <div class="border-t border-gray-200"></div>
                        <!-- amigos -->
                        <x-dropdown-link href="{{ route('friends.show') }}">
                            <i class="fa-solid fa-user-group"></i> Amigos
                        </x-dropdown-link>
                        <div class="border-t border-gray-200"></div>
                        <!-- Tema oscuro -->
                        <x-dropdown-link href="{{ route('temaoscuro.cambiartema') }}"
                            active="request()->routeIs('temaoscuro.cambiartema')">
                            @if (auth()->user()->temaoscuro)
                                <i class="fa-regular fa-moon"></i> Modo oscuro
                            @else
                                <i class="fa-regular fa-sun"></i> Modo claro
                            @endif
                        </x-dropdown-link>
                        <div class="border-t border-gray-200"></div>
                        <!-- Likes -->
                        <x-dropdown-link href="{{ route('publicationslikes.show', ['id' => auth()->user()->id]) }}">
                            <i class="fa-regular fa-heart"></i> Likes
                        </x-dropdown-link>
                        <div class="border-t border-gray-200"></div>
                        <!-- Guardados -->
                        <x-dropdown-link href="{{ route('publicationssaves.show', ['id' => auth()->user()->id]) }}">
                            <i class="fa-regular fa-floppy-disk"></i> Guardados
                        </x-dropdown-link>
                        <div class="border-t border-gray-200"></div>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                <i class="fa-solid fa-right-from-bracket"></i> {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        @else
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                            in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        @endauth
    </div>
</nav>
