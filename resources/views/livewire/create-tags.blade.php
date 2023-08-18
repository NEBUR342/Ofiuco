<div>
    <div class="flex flex-row-reverse mx-6 my-auto">
        <div title="NUEVA ETIQUETA" wire:click="$set('openCrear','true')"
            class="text-xl cursor-pointer bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-2 px-4 rounded">
            <i class="fa-regular fa-square-plus"></i>
        </div>
    </div>
    <x-dialog-modal wire:model="openCrear">
        <x-slot name="title">
            CREAR ETIQUETA
        </x-slot>
        <x-slot name="content">
            @wire('defer')
                <x-form-input name="nombre" label="Nombre de la etiqueta" />
                <x-form-textarea name="descripcion" label="Descripcion de la etiqueta" />
                <x-form-input name="color" type="color" label="Color" />
            @endwire
        </x-slot>
        <x-slot name="footer">
            <div class="flex flex-row-reverse">
                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                    wire:click="cerrar()">
                    <i class="fas fa-xmark mr-2"></i>Cancelar
                </button>
                <button class="mr-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                    wire:click="guardar()" wire:loading.attr="disabled">
                    <i class="fas fa-save mr-2"></i>Guardar
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
