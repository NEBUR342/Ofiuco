<?php
namespace App\Http\Livewire;

use App\Models\Tag;
use Livewire\{Component, WithPagination};

class CreateTags extends Component {
    use WithPagination;

    public bool $openCrear = false;
    public string $nombre ="",$descripcion="", $color = "";

    // Valido los campos de las etiquetas.
    protected function rules(): array {
        return [
            'nombre' => ['required', 'string', 'min:3', 'unique:tags,nombre', 'max:255'],
            'descripcion' => ['required', 'string', 'min:3'],
            'color' => ['required','regex:/#[A-Fa-f0-9]{6}/']
        ];
    }

    public function render() {
        return view('livewire.create-tags');
    }

    public function guardar() {
        // Hago que compruebe que los campos esten correctos.
        $this->validate();

        //Guardamos la etiqueta
        Tag::create([
            "nombre"=>$this->nombre,
            "descripcion"=>$this->descripcion,
            "color"=>$this->color
        ]);

        // Reseteo los campos de la ventana modal
        $this->reset(["openCrear","nombre","descripcion","color"]);

        // Provoco que se vea la nueva etiqueta creada
        $this->emitTo("show-tags","render");
        $this->emit("info", "Etiqueta creada");
    }

    public function cerrar() {
        $this->reset(["openCrear","nombre","descripcion","color"]);
    }

    public function openCrear() {
        $this->openCrear = true;
    }
}
