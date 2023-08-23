<?php

namespace App\Http\Livewire;

use App\Models\Community;
use Livewire\Component;
use Illuminate\Support\Facades\File;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CreateCommunity extends Component
{

    use WithPagination;
    use WithFileUploads;

    public bool $openCrear = false;
    public string $nombre = "", $descripcion = "";
    public $imagen;

    protected function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'min:3', 'unique:communities,nombre'],
            'descripcion' => ['required', 'string', 'min:10'],
            'imagen' => ['required', 'image', 'max:2048'],
        ];
    }

    public function render()
    {
        return view('livewire.create-community');
    }

    public function guardar()
    {
        $this->validate();
        $rutaImagen = $this->imagen->store('imagenesComunidad');
        Community::create([
            "nombre" => $this->nombre,
            "descripcion" => $this->descripcion,
            "imagen" => $rutaImagen,
            "user_id" => auth()->user()->id,
        ]);
        // Al trabajar con imagenes me genera la carpeta livewire-tmp pero no me la borra.
        // Para borrar la carpeta livewire-tmp que me genera livewire, he usado la siguiente solucion:
        File::deleteDirectory(storage_path('app/public/livewire-tmp'));
        $this->reset('openCrear', 'nombre', 'descripcion');
        return redirect()->route('communities.show');
    }

    public function cerrar()
    {
        $this->reset('openCrear', 'nombre', 'descripcion');
    }

    public function openCrear()
    {
        $this->openCrear = true;
    }
}
