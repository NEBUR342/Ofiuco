<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Community;
use App\Models\Like;
use App\Models\Publication;
use App\Models\Tag;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowPublication extends Component
{
    use WithFileUploads;

    public Publication $publicacion, $miPublicacion;
    public $selectedComunidades;
    public array $selectedTags = [];
    public bool $openEditar = false;
    public string $comentario = "", $contenido = "";
    private string $tipovalidacion = "publicacion sin comunidad";
    public $imagen;
    protected $listeners = ["render"];

    protected function rules(): array
    {
        switch ($this->tipovalidacion) {
            case "comentario":
                return [
                    'contenido' => ['required', 'string', 'min:1', 'max:100']
                ];
                break;
            case "publicacion sin comunidad":
                return [
                    'miPublicacion.titulo' => "",
                    'miPublicacion.contenido' => ['required', 'string', 'min:10'],
                    'miPublicacion.estado' => ['required', 'in:PUBLICADO,BORRADOR'],
                    'miPublicacion.imagen' => ['required', 'image', 'max:2048'],
                    'selectedTags' => ['required', 'exists:tags,id'],
                ];
                break;
            case "publicacion con comunidad":
                return [
                    'miPublicacion.titulo' => "",
                    'miPublicacion.contenido' => ['required', 'string', 'min:10'],
                    'miPublicacion.estado' => ['required', 'in:PUBLICADO,BORRADOR'],
                    'miPublicacion.comunidad' => ['required', 'exists:communities,id'],
                    'miPublicacion.imagen' => ['required', 'image', 'max:2048'],
                    'selectedTags' => ['required', 'exists:tags,id'],
                ];
                break;
        }
        return [];
    }

    public function mount($id)
    {
        $this->publicacion = Publication::findOrFail($id);
    }

    public function render()
    {
        $publicacion = Publication::where('id', $this->publicacion->id)->first();
        $this->publicacion = $publicacion;
        self::comprobarPublicacion();
        $autorPublicacion = $this->publicacion->user;
        if($publicacion->comunidad=="SI"){
            $comunidadesParticipado = auth()->user()->communities->pluck('nombre', 'id')->toArray();
            $comunidadesCreador = Community::where('user_id', $publicacion->user->id)->pluck('nombre', 'id')->toArray();
            $comunidades = $comunidadesParticipado + $comunidadesCreador;
        }
        $comunidades[0] = "Sin comunidad";
        ksort($comunidades);
        $etiquetas = Tag::orderBy('nombre')->pluck('nombre', 'id')->toArray();
        return view('livewire.show-publication', compact('publicacion', 'comunidades', 'etiquetas'));
    }

    public function borrarPublicacion()
    {
        self::comprobarPermisosPublicacion($this->publicacion);
        Storage::delete($this->publicacion->imagen);
        $this->publicacion->delete();
        return redirect()->route('dashboard');
    }

    public function darlike()
    {
        $like = new Like();
        $like->user_id = auth()->user()->id;
        $this->publicacion->likes()->save($like);
    }

    public function quitarlike()
    {
        $like = Like::where('publication_id', $this->publicacion->id)
            ->where('user_id', auth()->user()->id)
            ->first();
        $like->delete();
    }

    public function subirComentario()
    {
        $this->tipovalidacion = "comentario";
        $this->validate();
        Comment::create([
            "contenido" => $this->contenido,
            "user_id" => auth()->user()->id,
            "publication_id" => $this->publicacion->id
        ]);
        $this->contenido="";
    }

    public function quitarComentario(Comment $comentario)
    {
        self::comprobarPermisosPublicacion2($comentario);
        $comentario->delete();
        $this->emit('info', "Comentario eliminado");
    }

    public function editar(Publication $publicacion)
    {
        self::comprobarPermisosPublicacion($publicacion);
        $this->miPublicacion = $publicacion;
        if ($publicacion->comunidad == "SI") $this->selectedComunidades = $this->miPublicacion->community->id;
        $this->selectedTags = $this->miPublicacion->tags->pluck('id')->toArray();
        $this->openEditar = true;
    }

    public function update()
    {
        if ($this->selectedComunidades) {
            $this->tipovalidacion = "publicacion con comunidad";
        } else {
            $this->tipovalidacion = "publicacion sin comunidad";
        }
        $this->validate([
            'miPublicacion.titulo' => ['required', 'string', 'min:3', 'unique:publications,titulo,' . $this->publicacion->id]
        ]);
        if ($this->imagen) {
            Storage::delete($this->publicacion->imagen);
            $this->publicacion->imagen = $this->imagen->store('imagenesPublicacion');
        }
        if ($this->selectedComunidades) {
            $this->miPublicacion->update([
                "titulo" => $this->miPublicacion->titulo,
                "contenido" => $this->miPublicacion->contenido,
                "estado" => $this->miPublicacion->estado,
                "comunidad" => "SI",
                "imagen" => $this->publicacion->imagen,
                "community_id" => $this->selectedComunidades,
            ]);
        } else {
            $this->miPublicacion->update([
                "titulo" => $this->miPublicacion->titulo,
                "contenido" => $this->miPublicacion->contenido,
                "estado" => $this->miPublicacion->estado,
                "comunidad" => "NO",
                "imagen" => $this->publicacion->imagen,
                "community_id" => null,
            ]);
        }
        $this->miPublicacion->tags()->sync($this->selectedTags);
        $this->miPublicacion = new Publication();
        // Para borrar la carpeta livewire-tmp que me genera livewire, pero no la borra, he usado la siguiente solucion
        File::deleteDirectory(storage_path('app/public/livewire-tmp'));
        $this->reset('openEditar');
        $this->emit('info', 'Publicacion editada con éxito');
    }

    // Si no debo mostrar la publicacion, voy a forzar el error 404 (pagina no encontrada).
    // No lo hago con politicas ya que no me aclaraba con como seria al tener que comprobar todos estos campos.
    // Se me hacia muy dificil comprobarlo con las comunidades, por lo que he decidido hacerlo a mano.
    private function comprobarPublicacion()
    {
        // Si el usuario no esta autenticado compruebo dos cosas
        // Publicacion en BORRADOR y comunidad en SI (si se cumple al menos una muestro el error)
        // El usuario no autenticado, por lo que no pertenece a una comunidad y si el estado esta en borrador, no puede verlo.
        if (!auth()->user() && ($this->publicacion->estado == "BORRADOR" || $this->publicacion->comunidad == "SI")) {
            abort(404);
        } elseif (auth()->user()) {
            // Si el usuario no es administrador y la publicacion no le pertenece es posible que deba mostrar el mensaje de error
            if (!auth()->user()->is_admin && auth()->user()->id != $this->publicacion->user_id) {
                // Compruebo que la publicacion pertenezca a una comunidad
                if ($this->publicacion->comunidad == "SI") {
                    // la publicacion pertenece a una comunidad, pero ahora debo comprobar que el usuario autenticado pertenece a dicha comunidad
                    $aux = false;
                    foreach (auth()->user()->communities as $comunidad) {
                        if ($comunidad->id == $this->publicacion->community_id) {
                            $aux = true;
                        }
                    }
                    // Si eres el dueño de una comunidad y la publicacion pertenece a tu comunidad
                    // En el foreach de antes solo compruebo los participantes, no al creador.
                    if (auth()->user()->id == $this->publicacion->community->user_id) {
                        $aux = true;
                    }
                    // aux=false no pertenece | aux=true si pertenece
                    if ($aux) {
                        // Si perteneces a la comunidad pero esta en estado de BORRADOR no puedes verlo.
                        if ($this->publicacion->estado == "BORRADOR") {
                            abort(404);
                        }
                    } else {
                        // Si no perteneces a la comunidad no puedes ver la publicacion
                        abort(404);
                    }
                    // Si la publicacion no pertenece a una comunidad compruebo su estado.
                } elseif ($this->publicacion->estado == "BORRADOR") {
                    abort(404);
                }
            }
        }
    }

    public function comprobarPermisosPublicacion(Publication $publicacion){
        if(auth()->user()->is_admin) return;
        if($publicacion->comunidad=="SI") {
            if($publicacion->community->user_id==auth()->user()->id) return;
        }
        if($publicacion->user_id == auth()->user()->id) return;
        abort(404);
    }
    
    public function comprobarPermisosPublicacion2(Comment $comentario){
        if(auth()->user()->is_admin) return;
        if($comentario->user_id == auth()->user()->id) return;
        if($this->publicacion->user_id == auth()->user()->id)return;
        abort(404);
    }
}
