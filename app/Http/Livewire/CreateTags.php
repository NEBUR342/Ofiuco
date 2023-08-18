<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;

class CreateTags extends Component
{
    use WithPagination;
    public bool $openCrear = false;
    public string $nombre ="",$descripcion="", $color = "";

    protected function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'min:3', 'unique:tags,nombre'],
            'descripcion' => ['required', 'string', 'min:3'],
            'color' => ['required','regex:/#[A-Fa-f0-9]{6}/']
        ];
    }

    public function render()
    {
        return view('livewire.create-tags');
    }

    public function openCrear(){
        $this->openCrear = true;
    }

    public function guardar(){
        $this->validate();
        //Guardamos la categoría
        Tag::create([
            "nombre"=>$this->nombre,
            "descripcion"=>$this->descripcion,
            "color"=>$this->color
        ]);

        $this->reset(["openCrear","nombre","descripcion","color"]);
        $this->emitTo("show-tags","render");
        $this->emit("info", "Etiqueta creada");
    }

    public function cerrar(){
        $this->reset(["openCrear","nombre","descripcion","color"]);
    }
}
