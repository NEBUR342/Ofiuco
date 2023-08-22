<div>
    <div class="flex flex-row-reverse mx-6 my-auto">
        <div title="NUEVA COMUNIDAD" wire:click="$set('openCrear','true')"
            class="text-xl cursor-pointer bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-2 px-4 rounded">
            <i class="fa-solid fa-users-line"></i>
        </div>
    </div>
    <x-dialog-modal wire:model="openCrear">
        <x-slot name="title">
            <p class="text-white">CREAR UNA COMUNIDAD</p>
        </x-slot>
        <x-slot name="content">
            @wire('defer')
                <x-form-input name="nombre" label="Nombre de la comunidad" placeholder="Nombre ..."/>
                <x-form-textarea name="descripcion" placeholder="Descripcion..." label="Descripcion de la comunidad" rows="8"/>
            @endwire
            <div class="mt-4">
                <span class="text-gray-700">Imagen de la comunidad</span>
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
