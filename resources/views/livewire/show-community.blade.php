<div class="cursor-default">
    <div class="mt-3 flex flex-wrap justify-center">
        <div class="flex min-[700px]:w-1/2 max-[700px]:mb-3">
            <img src="{{ Storage::url($comunidad->imagen) }}" alt="Imagen de {{ $comunidad->nombre }}"
                class="mx-auto rounded-lg">
        </div>
        {{-- Contenido de la comunidad --}}
        <div class="flex flex-col min-[700px]:px-6 min-[700px]:w-1/2 max-[700px]:mx-5 mx-auto">
            <div @class([
                'rounded-xl',
                'bg-gray-700' => auth()->user()->temaoscuro,
                'bg-gray-200' => !auth()->user()->temaoscuro,
            ])>
                <div class="text-xl my-5 text-center mx-5">{{ $comunidad->nombre }}</div>
                <div class="mb-5 mx-5">{{ $comunidad->descripcion }}</div>
                <div class="mt-5 mx-5">Creador:
                    <span @class([
                        'rounded-xl cursor-pointer',
                        'bg-gray-500 py-1 px-2' => auth()->user()->temaoscuro,
                        'bg-gray-400 py-1 px-2' => !auth()->user()->temaoscuro,
                    ])
                        wire:click="buscarUsuario({{ $creador->id }})">{{ $creador->name }}
                    </span>
                </div>
                <div class="my-5 mx-5">Esta comunidad cuenta con: {{ $comunidad->users->count() }} participantes</div>
            </div>
            @auth
                <div class="flex flex-wrap text-xl">
                    @if (auth()->user()->id != $comunidad->user_id)
                        @if ($aux)
                            <div title="SALIR DE LA COMUNIDAD" wire:click="sacarParticipante({{ auth()->user() }})"
                                class="cursor-pointer mx-auto my-5 bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 rounded">
                                <i class="fa-solid fa-user-minus"></i>
                            </div>
                        @else
                            <div title="ENTRAR A LA COMUNIDAD" wire:click="meterParticipante"
                                class="cursor-pointer mx-auto my-5 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 rounded">
                                <i class="fa-solid fa-user-plus"></i>
                            </div>
                        @endif
                    @endif
                    @if ($aux || auth()->user()->id == $comunidad->user_id || auth()->user()->is_admin)
                        <div class="cursor-pointer mx-auto my-5 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 rounded"
                            wire:click="verPublicacionesComunidad" title="VER PUBLICACIONES DE LA COMUNIDAD">
                            <i class="fa-solid fa-users-rays"></i>
                        </div>
                    @endif
                    @if (auth()->user()->id == $comunidad->user_id || auth()->user()->is_admin)
                        <div title="EDITAR COMUNIDAD" wire:click="editar({{ $comunidad->id }})"
                            class="cursor-pointer mx-auto my-5 bg-transparent hover:bg-yellow-500 text-yellow-700 font-semibold hover:text-white py-2 px-4 rounded">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </div>
                        <div title="BORRAR COMUNIDAD" wire:click="borrarComunidad"
                            class="cursor-pointer mx-auto my-5 bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 rounded">
                            <i class="fa-solid fa-trash"></i>
                        </div>
                    @endif
                </div>
            @endauth
        </div>
    </div>
    @if (auth()->user()->id == $comunidad->user_id || auth()->user()->is_admin)
        <div class="mt-4 mx-2">
            @foreach ($comunidad->users->reverse() as $participante)
                <div @class([
                    'relative overflow-x-auto shadow-md rounded-lg my-3',
                    'bg-gray-700 hover:bg-gray-600 text-white' => auth()->user()->temaoscuro,
                    'bg-gray-200 hover:bg-gray-100' => !auth()->user()->temaoscuro,
                ])>
                    <div class="flex flex-wrap mx-3 mt-2">
                        <span class="flex flex-col mr-3 cursor-pointer"
                            wire:click="buscarUsuario({{ $participante->id }})">
                            <img class="h-8 w-8 rounded-full" src="{{ $participante->profile_photo_url }}"
                                alt="{{ $participante->name }}" />
                        </span>
                        <div class="text-xl">
                            {{ $participante->name }}
                        </div>
                    </div>
                    <div class="mx-3 mt-2 text-l">
                        {{ $participante->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="flex flex-row-reverse mx-6 my-4 ">
                        <i class="fa-regular fa-trash-can cursor-pointer text-red-500"
                            wire:click="sacarParticipante({{ $participante }})"></i>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    {{-- Ventana modal para editar --}}
    @if ($miComunidad)
        <x-dialog-modal wire:model="openEditar">
            <x-slot name="title">
                <p class="text-white">EDITAR UNA COMUNIDAD</p>
            </x-slot>
            <x-slot name="content">
                @wire($miComunidad, 'defer')
                    <x-form-input name="miComunidad.nombre" label="Nombre de la comunidad" placeholder="Nombre ..." />
                    <x-form-textarea name="miComunidad.descripcion" placeholder="Descripcion..."
                        label="Descripcion de la comunidad" rows="8" />
                @endwire
                <div class="mt-4">
                    <span class="text-gray-700">Imagen de la comunidad</span>
                </div>
                <div class="relative mt-4 w-full bg-gray-100">
                    @isset($imagen)
                        <img src="{{ $imagen->temporaryUrl() }}" class="rounded-xl w-full h-full">
                    @else
                        <img src="{{ Storage::url($comunidad->imagen) }}" class="rounded-xl w-full h-full">
                    @endisset
                    <label for="img"
                        class="absolute bottom-2 end-2 cursor-pointer
            bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Subir Imagen</label>
                    <input type="file" name="imagen" accept="image/*" class="hidden" id="img"
                        wire:model="imagen" />
                </div>
                @error('imagen')
                    <p class="text-red-500 italic text-xs">{{ $message }}</p>
                @enderror
            </x-slot>
            <x-slot name="footer">
                <div class="flex flex-row-reverse text-center">
                    <button
                        class="text-xl cursor-pointer bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-2 px-4 rounded mx-2"
                        wire:click="update" wire:loading.attr="disabled">
                        <i class="fas fa-save"></i>
                    </button>
                    <button
                        class="text-xl cursor-pointer bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 rounded"
                        wire:click="$set('openEditar', false)">
                        <i class="fas fa-xmark"></i>
                    </button>
                </div>
            </x-slot>
        </x-dialog-modal>
    @endif
</div>
