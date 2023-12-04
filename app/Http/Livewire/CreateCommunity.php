<?php
namespace App\Http\Livewire;

use App\Models\Community;
use Livewire\{Component, WithFileUploads, WithPagination};
use Illuminate\Support\Facades\File;

class CreateCommunity extends Component {
    use WithPagination;
    use WithFileUploads;

    public bool $openCrear = false;
    public string $nombre = "", $descripcion = "", $privacidad = "";
    public $imagen;

    protected function rules(): array {
        // compruebo los campos de la ventana modal.
        return [
            'nombre' => ['required', 'string', 'min:3', 'unique:communities,nombre', 'max:255'],
            'descripcion' => ['required', 'string', 'min:10'],
            'imagen' => ['required', 'image', 'max:2048', 'mimes:jpg,jpeg,png'],
            'privacidad' => ['required', 'in:PRIVADO,PUBLICO'],
        ];
    }

    public function render() {
        return view('livewire.create-community');
    }

    public function guardar() {
        // Valido los campos de la ventana modal.
        $this->validate();
        // guardo la imagen en la carpeta.
        $rutaImagen = $this->imagen->store('imagenesComunidad');
        // Creo la comunidad en la base de datos.
        Community::create([
            "nombre" => $this->nombre,
            "descripcion" => $this->descripcion,
            "imagen" => $rutaImagen,
            "privacidad" => $this->privacidad,
            "user_id" => auth()->user()->id,
        ]);
        $this->reset('openCrear', 'nombre', 'descripcion', 'privacidad');
        return redirect()->route('communities.show');
    }

    public function cerrar() {
        $this->reset('openCrear', 'nombre', 'descripcion', 'privacidad');
    }

    public function openCrear() {
        $this->openCrear = true;
    }
}
