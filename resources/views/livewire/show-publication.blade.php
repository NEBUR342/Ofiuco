<div class="cursor-default">
    @if ($publicacion)
        <div class="mt-3 flex flex-wrap justify-center">
            <div class="flex min-[700px]:w-1/2 max-[700px]:mx-2 max-[700px]:mb-3">
                <img src="{{ Storage::url($publicacion->imagen) }}" alt="Imagen de {{ $publicacion->user->name }}"
                    class="mx-auto rounded-lg">
            </div>
            {{-- Contenido de la publicacion --}}
            <div class="flex flex-col min-[700px]:px-6 min-[700px]:w-1/2 max-[700px]:mx-2 mx-auto">
                <div @class([
                    'rounded-xl',
                    'bg-gray-700 text-white' => auth()->check() && auth()->user()->temaoscuro,
                    'bg-gray-200' => auth()->guest() || !auth()->user()->temaoscuro,
                ])>
                    <div class="text-xl my-5 mx-5 text-center">{{ $publicacion->titulo }}</div>
                    <div class="mb-5 mx-5">{{ $publicacion->contenido }}</div>
                    <div class="flex flex-wrap justify-center">
                        @foreach ($publicacion->tags as $tag)
                            <div class="mx-auto px-2 py-1 rounded" style="background-color:{{ $tag->color }}">
                                {{ $tag->nombre }}</div>
                        @endforeach
                    </div>
                    <div class="flex flex-wrap justify-center text-center mt-5">
                        @auth
                            @if ($publicacion->likes->where('user_id', auth()->id())->count())
                                <i @class([
                                    'fa-solid fa-heart cursor-pointer px-2 py-1 rounded-lg mx-auto',
                                    'bg-red-500' => auth()->user()->temaoscuro,
                                    'bg-red-200' => !auth()->user()->temaoscuro,
                                ]) title="Quitar like"
                                    wire:click="quitarlike({{ $publicacion }})">
                                    <span class="mx-1">
                                        {{ $publicacion->likes->count() }}
                                    </span>
                                </i>
                            @else
                                <i @class([
                                    'fa-regular fa-heart cursor-pointer px-2 py-1 rounded-lg mx-auto',
                                    'bg-red-500' => auth()->user()->temaoscuro,
                                    'bg-red-200' => !auth()->user()->temaoscuro,
                                ]) title="Dar like" wire:click="darlike({{ $publicacion }})">
                                    <span class="mx-1">
                                        {{ $publicacion->likes->count() }}
                                    </span>
                                </i>
                            @endif
                        @else
                            <i class="fa-regular fa-heart bg-red-200 px-2 py-1 rounded-lg mx-auto"
                                title="No puedes dar like">
                                <span class="mx-1">
                                    {{ $publicacion->likes->count() }}
                                </span>
                            </i>
                        @endauth
                        @auth
                            @if (auth()->user()->id == $publicacion->user_id || auth()->user()->is_admin)
                                @if ($publicacion->estado == 'PUBLICADO')
                                    <div wire:click="cambiarEstado" @class([
                                        'mx-auto px-2 rounded-xl cursor-pointer',
                                        'bg-green-600' => auth()->user()->temaoscuro,
                                        'bg-green-400' => !auth()->user()->temaoscuro,
                                    ])>PUBLICADO</div>
                                @else
                                    <div wire:click="cambiarEstado" @class([
                                        'mx-auto px-2 rounded-xl cursor-pointer',
                                        'bg-red-600' => auth()->user()->temaoscuro,
                                        'bg-red-400' => !auth()->user()->temaoscuro,
                                    ])>BORRADOR</div>
                                @endif
                            @endif
                        @endauth

                    </div>
                    <div class="my-5 mx-5">Autor: {{ $publicacion->user->name }}</div>
                    @if ($publicacion->comunidad == 'SI')
                        <div class="mb-5 mx-5">Comunidad: {{ $publicacion->community->nombre }}</div>
                    @endif
                </div>
                @auth
                    @if (auth()->user()->id == $publicacion->user_id || auth()->user()->is_admin)
                        <div class="flex flex-wrap text-xl">
                            <div title="EDITAR PUBLICACION" wire:click="editar({{ $publicacion->id }})"
                                class="cursor-pointer mx-auto my-5 bg-transparent hover:bg-yellow-500 text-yellow-700 font-semibold hover:text-white py-2 px-4 rounded">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </div>
                            <div title="BORRAR PUBLICACION" wire:click="borrarPublicacion"
                                class="cursor-pointer mx-auto my-5 bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 rounded">
                                <i class="fa-solid fa-trash"></i>
                            </div>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
        {{-- Comentarios --}}
        <div class="mt-4 mx-2">
            @auth
                <div class="flex flex-wrap">
                    <div class="relative mb-3 w-5/6 min-[700px]:w-1/2">
                        @wire('defer')
                            <x-form-input name="contenido" label="Añade un comentario" />
                        @endwire
                    </div>
                    <div class="my-12 w-1/6 min-[700px]:w-1/2 mx-auto">
                        <div wire:click="subirComentario" title="ENVIAR COMENTARIO"
                            class="mx-1 text-xl w-6 text-center cursor-pointer bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white rounded">
                            <i class="fa-solid fa-right-long"></i>
                        </div>
                    </div>
                </div>
            @endauth
            @foreach ($publicacion->comments->reverse() as $comment)
                <div @class([
                    'relative overflow-x-auto shadow-md rounded-lg my-3',
                    'bg-gray-700 hover:bg-gray-600 text-white' =>
                        auth()->check() && auth()->user()->temaoscuro,
                    'hover:bg-gray-300' => auth()->guest() || !auth()->user()->temaoscuro,
                ])>
                    <div class="flex flex-wrap mt-2">
                        <span class="flex flex-col mr-3 cursor-pointer"
                            wire:click="buscarUsuario({{ $comment->user->id }})">
                            <img class="h-8 w-8 rounded-full ml-4" src="{{ $comment->user->profile_photo_url }}"
                                alt="{{ $comment->user->name }}" />
                        </span>
                        <div class="flex flex-col text-xl">
                            {{ $comment->user->name }}
                        </div>
                    </div>
                    <div class="flex flex-col text-l ml-2 mt-2">
                        {{ $comment->contenido }}
                    </div>
                    @auth
                        <div class="flex flex-row-reverse mx-6 my-4 ">
                            @if (auth()->user()->id == $publicacion->user->id || auth()->user()->id == $comment->user_id || auth()->user()->is_admin)
                                <i class="fa-regular fa-trash-can cursor-pointer text-red-500"
                                    wire:click="quitarComentario({{ $comment }})"></i>
                            @endif
                        </div>
                    @endauth
                </div>
            @endforeach
        </div>
        {{-- Ventana modal para editar --}}
        @if ($miPublicacion)
            <x-dialog-modal wire:model="openEditar">
                <x-slot name="title">
                    <p class="text-white">EDITAR UNA PUBLICACION</p>
                </x-slot>
                <x-slot name="content">
                    @wire($miPublicacion, 'defer')
                        <x-form-input name="miPublicacion.titulo" label="Título de la publicacion"
                            placeholder="Título ..." />
                        <x-form-textarea name="miPublicacion.contenido" placeholder="Contenido..."
                            label="Contenido de la publicacion" rows="8" />
                        <x-form-select name="selectedComunidades" :options="$comunidades" label="Comunidad de la publicacion"
                            wire:model="selectedComunidades" />
                        <x-form-group name="selectedTags[]" label="Etiquetas" inline>
                            @foreach ($etiquetas as $id => $nombre)
                                <x-form-checkbox name="tags" label="{{ $nombre }}" value="{{ $id }}"
                                    :wire=false :show-errors="false" wire:model='selectedTags' />
                            @endforeach
                        </x-form-group>
                        <x-form-group name="miPublicacion.estado" label="Estado de la publicacion" inline>
                            <x-form-radio name="miPublicacion.estado" value="PUBLICADO" label="Publicado" />
                            <x-form-radio name="miPublicacion.estado" value="BORRADOR" label="Borrador" />
                        </x-form-group>
                    @endwire
                    <div class="mt-4">
                        <span class="text-gray-700">Imagen de la publicacion</span>
                    </div>
                    <div class="relative mt-4 w-full bg-gray-100">
                        @isset($imagen)
                            <img src="{{ $imagen->temporaryUrl() }}" class="rounded-xl w-full h-full">
                        @else
                            <img src="{{ Storage::url($publicacion->imagen) }}" class="rounded-xl w-full h-full">
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
    @else
        <x-miscomponentes.sinresultados></x-miscomponentes.sinresultados>
    @endif
</div>
