<?php

namespace App\Http\Livewire;

use App\Models\Community;
use App\Models\Publication;
use App\Models\Tag;
use Livewire\Component;
use Illuminate\Support\Facades\File;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CreatePublication extends Component
{
    use WithPagination;
    use WithFileUploads;

    public bool $openCrear = false;
    public $imagen;
    public string $titulo = "", $contenido = "", $estado = "", $comunidad = "";
    public array $arraytags = [];

    protected function rules(): array
    {
        if ($this->comunidad) {
            return [
                'titulo' => ['required', 'string', 'min:3', 'unique:publications,titulo'],
                'contenido' => ['required', 'string', 'min:10'],
                'estado' => ['required', 'in:PUBLICADO,BORRADOR'],
                'comunidad' => ['required', 'exists:communities,id'],
                'imagen' => ['required', 'image', 'max:2048'],
                'arraytags' => ['nullable', 'exists:tags,id']
            ];
        } else {
            return [
                'titulo' => ['required', 'string', 'min:3', 'unique:publications,titulo'],
                'contenido' => ['required', 'string', 'min:10'],
                'estado' => ['required', 'in:PUBLICADO,BORRADOR'],
                'imagen' => ['required', 'image', 'max:2048'],
                'arraytags' => ['nullable', 'exists:tags,id'],
            ];
        }
    }

    public function render()
    {
        $tags = Tag::pluck('nombre', 'id')->toArray();
        $comunidadesParticipado = auth()->user()->communities->pluck('nombre', 'id')->toArray();
        $comunidadesCreador = Community::where('user_id', auth()->user()->id)->pluck('nombre', 'id')->toArray();
        $comunidades = $comunidadesParticipado + $comunidadesCreador;
        $comunidades[0] = "Sin comunidad";
        ksort($comunidades);
        return view('livewire.create-publication', compact('tags', 'comunidades'));
    }

    public function guardar()
    {
        $this->validate();
        $rutaImagen = $this->imagen->store('imagenesPublicacion');
        //Guardamos la categoría
        if ($this->comunidad) {
            $publicacion = Publication::create([
                "titulo" => $this->titulo,
                "contenido" => $this->contenido,
                "estado" => $this->estado,
                "comunidad" => "SI",
                "imagen" => $rutaImagen,
                "user_id" => auth()->user()->id,
                "community_id" => $this->comunidad,
            ]);
        } else {
            $publicacion = Publication::create([
                "titulo" => $this->titulo,
                "contenido" => $this->contenido,
                "estado" => $this->estado,
                "comunidad" => "NO",
                "imagen" => $rutaImagen,
                "user_id" => auth()->user()->id,
            ]);
        }
        $publicacion->tags()->attach($this->arraytags);
        // Para borrar la carpeta livewire-tmp que me genera livewire, pero no la borra, he usado la siguiente solucion
        File::deleteDirectory(storage_path('app/public/livewire-tmp'));
        $this->reset('openCrear', 'titulo', 'contenido', 'estado', 'arraytags', 'comunidad');
        return redirect()->route('publicationsuser.show',['id'=>$publicacion->user->id]);
    }

    public function cerrar()
    {
        $this->reset('openCrear', 'titulo', 'contenido', 'estado', 'arraytags', 'comunidad');
    }

    public function openCrear()
    {
        $this->openCrear = true;
    }
}
