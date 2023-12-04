<?php
namespace App\Http\Livewire;

use App\Models\{Comment, Community, Like, Publication, Save, Tag, User};
use Illuminate\Support\Facades\{File, Storage};
use Livewire\{Component, WithFileUploads};

class ShowPublication extends Component {
    use WithFileUploads;

    public Publication $publicacion, $miPublicacion;
    public $selectedComunidades;
    public array $selectedTags = [];
    public bool $openEditar = false;
    public string $comentario = "", $contenido = "";
    private string $tipovalidacion = "publicacion sin comunidad";
    public $imagen;
    protected $listeners = ["render"];

    protected function rules(): array {
        // Valido los campos diferenciando tres opciones:
        // El contenido de los comentarios.
        // Las publicaciones que pertenecen a una comunidad.
        // Las publicaciones que no pertenecen a una comunidad.
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

    public function mount($id) {
        $this->publicacion = Publication::findOrFail($id);
    }

    public function render() {
        // Obtengo la publicacion.
        $publicacion = Publication::where('id', $this->publicacion->id)->first();
        $this->publicacion = $publicacion;

        // compruebo que puedo acceder a la publicacion.
        self::comprobarPublicacion();

        // obtengo al autor de la publicacion, las etiquetas y las comunidades a las que pertenece el autor, y las comunidades que ha creado.
        $autorPublicacion = $this->publicacion->user;
        $etiquetas = Tag::orderBy('nombre')->pluck('nombre', 'id')->toArray();
        if (auth()->user() && $this->publicacion->user_id == auth()->user()->id) {
            $comunidadesParticipado = $autorPublicacion->communities->pluck('nombre', 'id')->toArray();
            $comunidadesCreador = Community::where('user_id', $publicacion->user->id)->pluck('nombre', 'id')->toArray();
            $comunidades = $comunidadesParticipado + $comunidadesCreador;
            $comunidades[0] = "Sin comunidad";
            ksort($comunidades);
        } else {
            $comunidades = Community::where('id', $publicacion->community_id)->pluck('nombre', 'id')->toArray();
        }
        $aux = false;
        $comunidad = $publicacion->community;
        if (auth()->user() && $comunidad != null && $comunidad->user_id == auth()->user()->id) $aux = true;
        return view('livewire.show-publication', compact('publicacion', 'comunidades', 'etiquetas', 'aux'));
    }

    public function borrarPublicacion() {
        // Compruebo que eres administrador o si es tuya.
        self::comprobarPermisosPublicacion($this->publicacion);

        // Borro la imagen de la carpeta
        Storage::delete($this->publicacion->imagen);

        // Borro la publicacion
        $this->publicacion->delete();
        return redirect()->route('dashboard');
    }

    public function darlike() {
        $like = new Like();
        $like->user_id = auth()->user()->id;
        $this->publicacion->likes()->save($like);
    }

    public function quitarlike() {
        $like = Like::where('publication_id', $this->publicacion->id)
            ->where('user_id', auth()->user()->id)
            ->first();
        $like->delete();
    }

    public function darsave() {
        $save = new Save();
        $save->user_id = auth()->user()->id;
        $this->publicacion->saves()->save($save);
    }

    public function quitarsave() {
        $save = Save::where('publication_id', $this->publicacion->id)
            ->where('user_id', auth()->user()->id)
            ->first();
        $save->delete();
    }

    public function subirComentario() {
        // Valido el comentario
        $this->tipovalidacion = "comentario";
        $this->validate();

        // creo el comentario
        Comment::create([
            "contenido" => $this->contenido,
            "user_id" => auth()->user()->id,
            "publication_id" => $this->publicacion->id
        ]);

        // Reseteo el contenido de la caja de texto.
        $this->contenido = "";
    }

    public function quitarComentario(Comment $comentario) {
        // Compruebo si eres administrador, dueño de la publicacion o dueño del comentario.
        self::comprobarPermisosPublicacion2($comentario);

        // Borro el comentario.
        $comentario->delete();
        $this->emit('info', "Comentario eliminado");
    }

    public function editar() {
        // Compruebo que eres administrador, si perteneces a la comunidad o si es tuya.
        self::comprobarPermisosPublicacion();

        // Le doy los valores de la publicacion a una variable auxiliar.
        $this->miPublicacion = $this->publicacion;

        // Si pertenece a una comunidad he usado una variable auxiliar para guardar la comunidad a la que pertenece la publicacion.
        if ($this->publicacion->comunidad == "SI") $this->selectedComunidades = $this->miPublicacion->community->id;

        // Guardo las etiquetas de la publicacion en un array.
        $this->selectedTags = $this->miPublicacion->tags->pluck('id')->toArray();
        $this->openEditar = true;
    }

    public function update() {
       // Diferencio las validaciones en caso de que tenga comunidad o no.
       if ($this->selectedComunidades) {
            $this->tipovalidacion = "publicacion con comunidad";
        } else {
            $this->tipovalidacion = "publicacion sin comunidad";
        }
        // Valido los campos de la ventana modal de la publicacion que quiero editar.
        $this->validate([
            'miPublicacion.titulo' => ['required', 'string', 'min:3', 'unique:publications,titulo,' . $this->publicacion->id]
        ]);
        // Agregar borrar likes, comentarios y guardados al cambiar la comunidad.
        // Compruebo si elijes una comunidad diferente a la que ya tenias.
        if ($this->selectedComunidades && $this->selectedComunidades != $this->publicacion->community_id) {
            $comunidadseleccionada = Community::where('id', $this->selectedComunidades)->first();
            // Primero borro los comentarios de los usuarios que no pertenecen a la nueva comunidad.
            $comentarios = $this->publicacion->comments;
            foreach ($comentarios as $comentario) {
                $usuario = $comentario->user;
                if (!$usuario->is_admin && ($comunidadseleccionada->user_id != $usuario->id && !$usuario->communities->contains('id', $comunidadseleccionada->id))) {
                    $comentario->delete();
                }
            }
            // A continuacion borro los likes de los usuarios que no pertenecen a la nueva comunidad.
            $likes = $this->publicacion->likes;
            foreach ($likes as $like) {
                $usuario = $like->user;
                if (!$usuario->is_admin && ($comunidadseleccionada->user_id != $usuario->id && !$usuario->communities->contains('id', $comunidadseleccionada->id))) {
                    $like->delete();
                }
            }
            // A continuacion borro los saves de los usuarios que no pertenecen a la nueva comunidad.
            $saves = $this->publicacion->saves;
            foreach ($saves as $save) {
                $usuario = $save->user;
                if (!$usuario->is_admin && ($comunidadseleccionada->user_id != $usuario->id && !$usuario->communities->contains('id', $comunidadseleccionada->id))) {
                    $save->delete();
                }
            }
        }

        // Si he modificado la imagen borro la antigua y guardo la nueva.
        if ($this->imagen) {
            Storage::delete($this->publicacion->imagen);
            $this->publicacion->imagen = $this->imagen->store('imagenesPublicacion');
        }

        // Guardo los nuevos valores de la publicacion diferenciando si pertenece a una comunidad o no.
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
        // guardo los cambios de la tabla auxiliar con las etiquetas.
        $this->miPublicacion->tags()->sync($this->selectedTags);
        // Reseteo los campos de la variable auxiliar.
        $this->miPublicacion = new Publication();
        $this->reset('openEditar');
        $this->emit('info', 'Publicacion editada con éxito');
    }

    // Aqui cambio el estado del post de publicado a borrador y viceversa
    public function cambiarEstado() {
        if ($this->publicacion->estado == "BORRADOR") {
            $this->publicacion->update([
                "estado" => "PUBLICADO"
            ]);
        } else {
            $this->publicacion->update([
                "estado" => "BORRADOR"
            ]);
        }
    }

    public function buscarUsuario() {
        $id=$this->publicacion->user->id;
        return redirect()->route('perfiluser.show', compact('id'));
    }

    public function buscarComunidad() {
        $id=$this->publicacion->community->id;
        return redirect()->route('community.show', compact('id'));
    }

    // Si no debo mostrar la publicacion, voy a forzar el error 404 (pagina no encontrada).
    // No lo hago con politicas ya que no me aclaraba con como seria al tener que comprobar todos estos campos.
    // Se me hacia muy dificil comprobarlo con las comunidades, por lo que he decidido hacerlo a mano.
    private function comprobarPublicacion()
    {
        // Compruebo dos cosas.
        // Estado de la publicacion en PUBLICADO.
        // Comunidad en no.
        if ($this->publicacion->estado == "PUBLICADO" && $this->publicacion->comunidad == "NO")  return;
        if (!auth()->user()) abort(404);

        // si el usuario autenticado es adminidtrador.
        if (auth()->user()->is_admin) return;

        // si la publicacion te pertenece
        if ($this->publicacion->user_id == auth()->user()->id) return;

        if ($this->publicacion->comunidad == "NO") abort(404);

        // si eres el dueño de la comunidad a la que pertenece la publicacion
        if ($this->publicacion->community->user_id == auth()->user()->id) return;

        // Si la publicacion esta en estado borrador, dara un error.
        if ($this->publicacion->estado == "BORRADOR") abort(404);

        // compruebo que pertenezcas a la comunidad a la que pertenece la publicacion.
        $comunidad = $this->publicacion->community;
        foreach ($comunidad->users as $usuario) {
            if ($usuario->id == auth()->user()->id) return;
        }
        abort(404);
    }

    // Compruebo que eres administrador, dueño de la comunidad a la que pertenece la publicación o si es tuya.
    public function comprobarPermisosPublicacion() {
        if (auth()->user()->is_admin) return;
        if ($this->publicacion->user_id == auth()->user()->id) return;
        if ($this->publicacion->comunidad == 'SI' && $this->publicacion->community->user_id == auth()->user()->id) return;
        abort(404);
    }

    // Compruebo si eres administrador, dueño de la publicacion o dueño del comentario.
    public function comprobarPermisosPublicacion2(Comment $comentario) {
        if (auth()->user()->is_admin) return;
        if ($comentario->user_id == auth()->user()->id) return;
        if ($this->publicacion->user_id == auth()->user()->id) return;
        abort(404);
    }
}
