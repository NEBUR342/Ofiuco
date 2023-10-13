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

    // Aqui voy a gestionar las reglas de validacion que tienen que seguir las publicaciones al ser creadas.
    protected function rules(): array
    {
        // Separo las correcciones de si has elegido que pertenezca a una comunidad o no.
        if ($this->comunidad) {
            // Pertenece a una comunidad.
            return [
                'titulo' => ['required', 'string', 'min:3', 'unique:publications,titulo'],
                'contenido' => ['required', 'string', 'min:10'],
                'estado' => ['required', 'in:PUBLICADO,BORRADOR'],
                'comunidad' => ['required', 'exists:communities,id'],
                'imagen' => ['required', 'image', 'max:2048', 'mimes:jpg,jpeg,png'],
                'arraytags' => ['nullable', 'exists:tags,id']
            ];
        } else {
            // No pertenece a una comunidad.
            return [
                'titulo' => ['required', 'string', 'min:3', 'unique:publications,titulo'],
                'contenido' => ['required', 'string', 'min:10'],
                'estado' => ['required', 'in:PUBLICADO,BORRADOR'],
                'imagen' => ['required', 'image', 'max:2048', 'mimes:jpg,jpeg,png'],
                'arraytags' => ['nullable', 'exists:tags,id'],
            ];
        }
    }

    public function render()
    {
        // Obtengo los tags.
        $tags = Tag::pluck('nombre', 'id')->toArray();

        // Obtengo las comunidades en las que soy participante.
        $comunidadesParticipado = auth()->user()->communities->pluck('nombre', 'id')->toArray();

        // Obtengo las comunidades en las que soy el creador.
        $comunidadesCreador = Community::where('user_id', auth()->user()->id)->pluck('nombre', 'id')->toArray();

        // Guardo todas estas comunidades en una sola variable.
        $comunidades = $comunidadesParticipado + $comunidadesCreador;

        // Doy la opcion de que no pertenezca a una comunidad.
        $comunidades[0] = "Sin comunidad";

        // Ordeno las comunidades por id.
        ksort($comunidades);
        return view('livewire.create-publication', compact('tags', 'comunidades'));
    }

    public function guardar()
    {
        // Validamos la publicacion antes de guardarla.
        $this->validate();

        // Guardo la imagen.
        $rutaImagen = $this->imagen->store('imagenesPublicacion');

        // Guardo la publicacion, diferenciando si pertenece a una comunidad o no.
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
        // Guardo en la tabla auxiliar los tags añadidos a la publicacion.
        $publicacion->tags()->attach($this->arraytags);

        // Para borrar la carpeta livewire-tmp que me genera livewire, pero no la borra, he usado la siguiente solucion
        File::deleteDirectory(storage_path('app/public/livewire-tmp'));

        // Reseteo los campos de la ventana modal
        $this->reset('openCrear', 'titulo', 'contenido', 'estado', 'arraytags', 'comunidad');

        // Devuelvo a la persona a su vista.
        // Si creas la publicacion viendo las publicaciones de otro usuario, te devuelvo a tu vista, no a la del otro usuario
        $id=auth()->user()->id;
        return redirect()->route('perfiluser.show',compact('id'));
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
