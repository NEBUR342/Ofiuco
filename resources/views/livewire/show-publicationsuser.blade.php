<div class='min-[480px]:px-12 mt-4 cursor-default'>
    <div class="h-16"></div>
    <div class="min-[700px]:flex min-[700px]:flex-wrap items-center">
        <div class="min-[700px]:flex mb-6 min-[700px]:w-1/3 items-center justify-center">
            <span class="flex flex-col items-center">
                <img class="h-32 w-32 min-[700px]:h-48 min-[700px]:w-48 rounded-full ml-4" src="{{ $usuario->profile_photo_url }}"
                    title="Publicaciones de {{ $usuario->name }}" alt="{{ $usuario->name }}" />
            </span>
        </div>
        <div class="flex-1 justify-center items-center min-[700px]:w-2/3">
            <div class="flex justify-around">
                @if (auth()->user()->id != $usuario->id)
                    <div wire:click="" class="bg-red-600 hover:bg-red-700 p-2 rounded-lg cursor-pointer">SEGUIR</div>
                    @if (!(auth()->user()->friends->contains('frienduno_id', $usuario->id) || auth()->user()->friends->contains('frienddos_id', $usuario->id)))
                        <span class="min-[480px]:ml-12 cursor-pointer bg-transparent hover:bg-blue-500 text-blue-500 font-semibold hover:text-white py-2 px-4 rounded">
                            <i class="fa-solid fa-user-plus"
                                wire:click="solicitudamigo({{ $usuario->id }})"></i>
                        </span>
                    @elseif(auth()->user()->id != $usuario->id)
                        <span class="min-[480px]:ml-12 cursor-pointer bg-transparent hover:bg-red-500 text-red-500 font-semibold hover:text-white py-2 px-4 rounded">
                            <i class="fa-solid fa-user-minus"
                                wire:click="borraramigo({{ $usuario->id }})"></i>
                        </span>
                    @endif
                    <span title="VER LIKES DEL USUARIO" wire:click="buscarLikesUsuario()"
                        class="min-[480px]:ml-12 cursor-pointer bg-transparent hover:bg-yellow-500 text-yellow-500 font-semibold hover:text-white py-2 px-4 rounded">
                        <i class="fa-regular fa-face-grin-hearts"></i>
                    </span>
                @else
                    <a href="{{ route('profile.show') }}" class="bg-red-600 hover:bg-red-700 p-2 rounded-lg">PROFILE</a>
                @endif
            </div>
            <div class="flex flex-wrap text-xl">
                <a title="COMPARTIR PERFIL"
                    href="https://api.whatsapp.com/send?text=http://127.0.0.1:8000/publications/{{ $usuario->id }}"
                    class="cursor-pointer mx-auto my-5">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50"
                        viewBox="0 0 48 48">
                        <path fill="#fff"
                            d="M4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98c-0.001,0,0,0,0,0h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303z">
                        </path>
                        <path fill="#fff"
                            d="M4.868,43.803c-0.132,0-0.26-0.052-0.355-0.148c-0.125-0.127-0.174-0.312-0.127-0.483l2.639-9.636c-1.636-2.906-2.499-6.206-2.497-9.556C4.532,13.238,13.273,4.5,24.014,4.5c5.21,0.002,10.105,2.031,13.784,5.713c3.679,3.683,5.704,8.577,5.702,13.781c-0.004,10.741-8.746,19.48-19.486,19.48c-3.189-0.001-6.344-0.788-9.144-2.277l-9.875,2.589C4.953,43.798,4.911,43.803,4.868,43.803z">
                        </path>
                        <path fill="#cfd8dc"
                            d="M24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,4C24.014,4,24.014,4,24.014,4C12.998,4,4.032,12.962,4.027,23.979c-0.001,3.367,0.849,6.685,2.461,9.622l-2.585,9.439c-0.094,0.345,0.002,0.713,0.254,0.967c0.19,0.192,0.447,0.297,0.711,0.297c0.085,0,0.17-0.011,0.254-0.033l9.687-2.54c2.828,1.468,5.998,2.243,9.197,2.244c11.024,0,19.99-8.963,19.995-19.98c0.002-5.339-2.075-10.359-5.848-14.135C34.378,6.083,29.357,4.002,24.014,4L24.014,4z">
                        </path>
                        <path fill="#40c351"
                            d="M35.176,12.832c-2.98-2.982-6.941-4.625-11.157-4.626c-8.704,0-15.783,7.076-15.787,15.774c-0.001,2.981,0.833,5.883,2.413,8.396l0.376,0.597l-1.595,5.821l5.973-1.566l0.577,0.342c2.422,1.438,5.2,2.198,8.032,2.199h0.006c8.698,0,15.777-7.077,15.78-15.776C39.795,19.778,38.156,15.814,35.176,12.832z">
                        </path>
                        <path fill="#fff" fill-rule="evenodd"
                            d="M19.268,16.045c-0.355-0.79-0.729-0.806-1.068-0.82c-0.277-0.012-0.593-0.011-0.909-0.011c-0.316,0-0.83,0.119-1.265,0.594c-0.435,0.475-1.661,1.622-1.661,3.956c0,2.334,1.7,4.59,1.937,4.906c0.237,0.316,3.282,5.259,8.104,7.161c4.007,1.58,4.823,1.266,5.693,1.187c0.87-0.079,2.807-1.147,3.202-2.255c0.395-1.108,0.395-2.057,0.277-2.255c-0.119-0.198-0.435-0.316-0.909-0.554s-2.807-1.385-3.242-1.543c-0.435-0.158-0.751-0.237-1.068,0.238c-0.316,0.474-1.225,1.543-1.502,1.859c-0.277,0.317-0.554,0.357-1.028,0.119c-0.474-0.238-2.002-0.738-3.815-2.354c-1.41-1.257-2.362-2.81-2.639-3.285c-0.277-0.474-0.03-0.731,0.208-0.968c0.213-0.213,0.474-0.554,0.712-0.831c0.237-0.277,0.316-0.475,0.474-0.791c0.158-0.317,0.079-0.594-0.04-0.831C20.612,19.329,19.69,16.983,19.268,16.045z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
                <a title="COMPARTIR PERFIL"
                    href="http://www.facebook.com/sharer.php?u=http://127.0.0.1:8000/publications/{{ $usuario->id }}&t=Mira el perfil de {{ $usuario->name }} en Ofiuco"
                    target="_blank" class="cursor-pointer mx-auto my-5">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50"
                        viewBox="0 0 64 64">
                        <radialGradient id="7jnoslngIja1InKyh66Ura_118960_gr1" cx="32" cy="31.5"
                            r="31.259" gradientUnits="userSpaceOnUse" spreadMethod="reflect">
                            <stop offset="0" stop-color="#c5f1ff"></stop>
                            <stop offset=".35" stop-color="#cdf3ff"></stop>
                            <stop offset=".907" stop-color="#e4faff"></stop>
                            <stop offset="1" stop-color="#e9fbff"></stop>
                        </radialGradient>
                        <path fill="url(#7jnoslngIja1InKyh66Ura_118960_gr1)"
                            d="M58,54c-1.105,0-2-0.895-2-2c0-1.105,0.895-2,2-2h2.5c1.925,0,3.5-1.575,3.5-3.5 S62.425,43,60.5,43H50c-1.381,0-2.5-1.119-2.5-2.5c0-1.381,1.119-2.5,2.5-2.5h8c1.65,0,3-1.35,3-3c0-1.65-1.35-3-3-3H42v-6h18 c2.335,0,4.22-2.028,3.979-4.41C63.77,19.514,61.897,18,59.811,18H58c-1.105,0-2-0.895-2-2c0-1.105,0.895-2,2-2h0.357 c1.308,0,2.499-0.941,2.63-2.242C61.137,10.261,59.966,9,58.5,9h-14C43.672,9,43,8.328,43,7.5S43.672,6,44.5,6h3.857 c1.308,0,2.499-0.941,2.63-2.242C51.137,2.261,49.966,1,48.5,1L15.643,1c-1.308,0-2.499,0.941-2.63,2.242 C12.863,4.739,14.034,6,15.5,6H19c1.105,0,2,0.895,2,2c0,1.105-0.895,2-2,2H6.189c-2.086,0-3.958,1.514-4.168,3.59 C1.78,15.972,3.665,18,6,18h2.5c1.933,0,3.5,1.567,3.5,3.5c0,1.933-1.567,3.5-3.5,3.5H5.189c-2.086,0-3.958,1.514-4.168,3.59 C0.78,30.972,2.665,33,5,33h17v11H6c-1.65,0-3,1.35-3,3c0,1.65,1.35,3,3,3h0c1.105,0,2,0.895,2,2c0,1.105-0.895,2-2,2H4.189 c-2.086,0-3.958,1.514-4.168,3.59C-0.22,59.972,1.665,62,4,62h53.811c2.086,0,3.958-1.514,4.168-3.59C62.22,56.028,60.335,54,58,54z">
                        </path>
                        <linearGradient id="7jnoslngIja1InKyh66Urb_118960_gr2" x1="32" x2="32"
                            y1="61.521" y2="17.521" gradientUnits="userSpaceOnUse" spreadMethod="reflect">
                            <stop offset="0" stop-color="#155cde"></stop>
                            <stop offset=".278" stop-color="#1f7fe5"></stop>
                            <stop offset=".569" stop-color="#279ceb"></stop>
                            <stop offset=".82" stop-color="#2cafef"></stop>
                            <stop offset="1" stop-color="#2eb5f0"></stop>
                        </linearGradient>
                        <path fill="url(#7jnoslngIja1InKyh66Urb_118960_gr2)"
                            d="M50,12H14c-2.209,0-4,1.791-4,4v36c0,2.209,1.791,4,4,4h36c2.209,0,4-1.791,4-4V16 C54,13.791,52.209,12,50,12z">
                        </path>
                        <path fill="#fff"
                            d="M44.4,35H41v15c0,0.552-0.448,1-1,1h-4c-0.552,0-1-0.448-1-1V35h-3c-0.552,0-1-0.448-1-1v-3 c0-0.552,0.448-1,1-1h3v-3.069C35.005,22.582,36.812,20,41.936,20H45c0.552,0,1,0.448,1,1v3c0,0.552-0.448,1-1,1h-1.874 C41.131,25,41,25.746,41,27.136V30h4c0.631,0,1.104,0.577,0.981,1.196l-0.6,3C45.287,34.664,44.876,35,44.4,35z">
                        </path>
                    </svg>
                </a>
                <a title="COMPARTIR PERFIL"
                    href="https://twitter.com/intent/tweet?text=Mira el perfil de {{ $usuario->name }} de Ofiuco en:&url=http://127.0.0.1:8000/community/{{ $usuario->id }}"
                    target="_blank" class="cursor-pointer mx-auto my-5">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50"
                        height="50" viewBox="0 0 48 48">
                        <path fill="#03A9F4"
                            d="M42,12.429c-1.323,0.586-2.746,0.977-4.247,1.162c1.526-0.906,2.7-2.351,3.251-4.058c-1.428,0.837-3.01,1.452-4.693,1.776C34.967,9.884,33.05,9,30.926,9c-4.08,0-7.387,3.278-7.387,7.32c0,0.572,0.067,1.129,0.193,1.67c-6.138-0.308-11.582-3.226-15.224-7.654c-0.64,1.082-1,2.349-1,3.686c0,2.541,1.301,4.778,3.285,6.096c-1.211-0.037-2.351-0.374-3.349-0.914c0,0.022,0,0.055,0,0.086c0,3.551,2.547,6.508,5.923,7.181c-0.617,0.169-1.269,0.263-1.941,0.263c-0.477,0-0.942-0.054-1.392-0.135c0.94,2.902,3.667,5.023,6.898,5.086c-2.528,1.96-5.712,3.134-9.174,3.134c-0.598,0-1.183-0.034-1.761-0.104C9.268,36.786,13.152,38,17.321,38c13.585,0,21.017-11.156,21.017-20.834c0-0.317-0.01-0.633-0.025-0.945C39.763,15.197,41.013,13.905,42,12.429">
                        </path>
                    </svg>
                </a>
                <a title="COMPARTIR PERFIL"
                    href="https://www.reddit.com/submit?url=http://127.0.0.1:8000/community/{{ $usuario->id }}"
                    target="_blank" class="cursor-pointer mx-auto my-5">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50"
                        height="50" viewBox="0 0 48 48">
                        <path fill="#64717c"
                            d="M24,18c-0.552,0-1-0.448-1-1c0-2.815,0.36-12,5-12c1.173,0,2.037,0.676,2.872,1.331    C31.919,7.151,33.002,8,35,8h4c0.552,0,1,0.448,1,1s-0.448,1-1,1h-4c-2.688,0-4.233-1.211-5.362-2.095C28.922,7.344,28.46,7,28,7    c-1.738,0-3,4.206-3,10C25,17.552,24.552,18,24,18z">
                        </path>
                        <radialGradient id="PTH08zocUYAZh7xvCE~aha_h3FOPWMfgNnV_gr1" cx="36.257" cy="27.553"
                            r="11.69" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="#bbc1c4"></stop>
                            <stop offset=".652" stop-color="#bbc1c4"></stop>
                            <stop offset=".74" stop-color="#c1c7c9"></stop>
                            <stop offset=".861" stop-color="#d3d6d8"></stop>
                            <stop offset="1" stop-color="#f0f0f0"></stop>
                        </radialGradient>
                        <circle cx="40" cy="22" r="5"
                            fill="url(#PTH08zocUYAZh7xvCE~aha_h3FOPWMfgNnV_gr1)"></circle>
                        <radialGradient id="PTH08zocUYAZh7xvCE~ahb_h3FOPWMfgNnV_gr2" cx="36.257" cy="27.553"
                            r="11.69" gradientTransform="matrix(-1 0 0 1 48 0)" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="#bbc1c4"></stop>
                            <stop offset=".652" stop-color="#bbc1c4"></stop>
                            <stop offset=".74" stop-color="#c1c7c9"></stop>
                            <stop offset=".861" stop-color="#d3d6d8"></stop>
                            <stop offset="1" stop-color="#f0f0f0"></stop>
                        </radialGradient>
                        <circle cx="8" cy="22" r="5"
                            fill="url(#PTH08zocUYAZh7xvCE~ahb_h3FOPWMfgNnV_gr2)"></circle>
                        <linearGradient id="PTH08zocUYAZh7xvCE~ahc_h3FOPWMfgNnV_gr3" x1="24" x2="24"
                            y1="14.955" y2="42.955" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="#f0f0f0"></stop>
                            <stop offset="1" stop-color="#bbc1c4"></stop>
                        </linearGradient>
                        <ellipse cx="24" cy="29" fill="url(#PTH08zocUYAZh7xvCE~ahc_h3FOPWMfgNnV_gr3)"
                            rx="19" ry="14"></ellipse>
                        <path fill="#d43a02"
                            d="M30,23c-1.656-0.001-2.999,1.341-3,2.998c-0.001,1.656,1.341,2.999,2.998,3c0.001,0,0.002,0,0.002,0  c1.656,0.001,2.999-1.341,3-2.998c0.001-1.656-1.341-2.999-2.998-3C30.002,23,30.001,23,30,23z">
                        </path>
                        <path fill="#d43a02"
                            d="M18,23c-1.656-0.001-2.999,1.341-3,2.998c-0.001,1.656,1.341,2.999,2.998,3c0.001,0,0.002,0,0.002,0    c1.656,0.001,2.999-1.341,3-2.998c0.001-1.656-1.341-2.999-2.998-3C18.002,23,18.001,23,18,23z">
                        </path>
                        <path fill="#64717c"
                            d="M24.002,34.902c-3.252,0-6.14-0.745-8.002-1.902c1.024,2.044,4.196,4,8.002,4  c3.802,0,6.976-1.956,7.998-4C30.143,34.157,27.254,34.902,24.002,34.902z">
                        </path>
                        <linearGradient id="PTH08zocUYAZh7xvCE~ahd_h3FOPWMfgNnV_gr4" x1="36.995" x2="41.392"
                            y1="6.995" y2="11.392" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="#f0f0f0"></stop>
                            <stop offset="1" stop-color="#bbc1c4"></stop>
                        </linearGradient>
                        <circle cx="39" cy="9" r="3"
                            fill="url(#PTH08zocUYAZh7xvCE~ahd_h3FOPWMfgNnV_gr4)"></circle>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div class="flex mb-3">
        <div class="flex-1">
            <x-input class="w-full text-gray-800" type='search' placeholder="Buscar publicaciones..."
                wire:model="buscar"></x-input>
        </div>
        @if (auth()->user()->id == $usuario->id)
            <div>
                @livewire('create-publication')
            </div>
        @endif
    </div>
    <div @class([
        'font-bold text-xl text-center mt-4',
        'text-white' => auth()->user()->temaoscuro,
    ])>
        <span class="mx-3 cursor-pointer" wire:click="ordenar('titulo')" title="ORDENAR POR TITULO"><i
                class="fa-solid fa-arrow-down-a-z"></i></span>
        <span class="mx-3 cursor-pointer" wire:click="ordenar('comunidades')" title="ORDENAR POR COMUNIDAD"><i
                class="fa-solid fa-users"></i></span>
        <span class="mx-3 cursor-pointer" wire:click="ordenar('likes')" title="ORDENAR POR LIKES"><i
                class="fa-solid fa-fire"></i></span>
        <span class="mx-3 cursor-pointer" wire:click="ordenar('creacion')" title="ORDENAR POR ANTIGUEDAD"><i
                class="fa-regular fa-clock"></i></span>
    </div>
    @if ($publicaciones->count())
        <div class="mt-3 flex flex-wrap justify-center text-center">
            @foreach ($publicaciones as $publicacion)
                <div wire:click="verPublicacion({{ $publicacion->id }})"
                    class="min-[480px]:rounded-lg flex flex-col w-1/3 h-1/3 min-[480px]:w-1/4 min-[480px]:m-3 border border-gray-800 cursor-pointer">
                    <img src="{{ Storage::url($publicacion->imagen) }}" alt="{{ $publicacion->titulo }}"
                        class="min-[480px]:rounded-lg">
                </div>
            @endforeach
        </div>
        {{ $publicaciones->links() }}
    @else
        <x-miscomponentes.sinresultados></x-miscomponentes.sinresultados>
    @endif
    <div class="min-[700px]:flex min-[700px]:flex-wrap text-center">
        <div class="min-[700px]:flex-1 mt-6">
            <h1 class="text-2xl">COMUNIDADES CREADAS</h1>
            @if ($comunidadesCreador->count())
                <div class="mt-3 flex flex-wrap justify-center text-center">
                    @foreach ($comunidadesCreador as $comunidad)
                        <div wire:click="verComunidad({{ $comunidad->id }})"
                            class="min-[480px]:rounded-lg flex flex-col w-1/3 h-1/3 min-[480px]:w-1/4 min-[480px]:m-3 border border-gray-800 cursor-pointer">
                            <img src="{{ Storage::url($comunidad->imagen) }}" alt="{{ $comunidad->nombre }}"
                                class="min-[480px]:rounded-lg">
                        </div>
                    @endforeach
                </div>
            @else
                <x-miscomponentes.sinresultados></x-miscomponentes.sinresultados>
            @endif
        </div>
        <div class="min-[700px]:flex-1 mt-6">
            <h1 class="text-2xl">PARTICIPANTE EN LAS COMUNIDADES</h1>
            @if ($comunidadesParticipado->count())
                <div class="mt-3 flex flex-wrap justify-center text-center">
                    @foreach ($comunidadesParticipado as $comunidad)
                        <div wire:click="verComunidad({{ $comunidad->id }})"
                            class="min-[480px]:rounded-lg flex flex-col w-1/3 h-1/3 min-[480px]:w-1/4 min-[480px]:m-3 border border-gray-800 cursor-pointer">
                            <img src="{{ Storage::url($comunidad->imagen) }}" alt="{{ $comunidad->nombre }}"
                                class="min-[480px]:rounded-lg">
                        </div>
                    @endforeach
                </div>
            @else
                <x-miscomponentes.sinresultados></x-miscomponentes.sinresultados>
            @endif
        </div>
    </div>
</div>
