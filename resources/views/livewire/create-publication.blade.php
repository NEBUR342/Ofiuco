<div>
    <div class="flex flex-row-reverse mx-6 my-auto">
        <div title="NUEVA PUBLICACION" wire:click="$set('openCrear','true')"
            class="text-xl cursor-pointer bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-2 px-4 rounded">
            <i class="fa-regular fa-square-plus"></i>
        </div>
    </div>
    <x-dialog-modal wire:model="openCrear">
        <x-slot name="title">
            <p class="text-white">CREAR UNA PUBLICACION</p>
        </x-slot>
        <x-slot name="content">
            @wire('defer')
                <x-form-input name="titulo" label="Título de la publicacion" placeholder="Título ..." />
                <x-form-textarea name="contenido" placeholder="Contenido..." label="Contenido de la publicacion" rows="8"/>
                <x-form-select name="comunidad" :options="$comunidades" label="Comunidad de la publicacion" />
                <x-form-group name="tags" label="Etiquetas" inline>
                    @foreach ($tags as $id => $nombre)
                        <x-form-checkbox name="arraytags" label="{{ $nombre }}" value="{{ $id }}" :show-errors="false" wire:model.defer="arraytags"/>
                    @endforeach
                </x-form-group>
                <x-form-group name="estado" label="Estado de la publicacion" inline>
                    <x-form-radio name="estado" value="PUBLICADO" label="Publicado" />
                    <x-form-radio name="estado" value="BORRADOR" label="Borrador" />
                </x-form-group>
            @endwire
            <div class="mt-4">
                <span class="text-gray-700">Imagen de la publicacion</span>
            </div>
            <div class="relative mt-4 w-full bg-gray-100">
                @isset($imagen)
                    <img src="{{ $imagen->temporaryUrl() }}" class="rounded-xl w-full h-full">
                @else
                    <img src="{{ Storage::url('noimage.jpg') }}" class="rounded-xl w-full h-full">
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
                <button class="text-xl cursor-pointer bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-2 px-4 rounded mx-2"
                    wire:click="guardar()" wire:loading.attr="disabled">
                    <i class="fas fa-save"></i>
                </button>
                <button class="text-xl cursor-pointer bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 rounded"
                    wire:click="cerrar()">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
