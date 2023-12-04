<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Community;
use App\Models\Like;
use App\Models\Publication;
use App\Models\Request;
use App\Models\Save;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowCommunity extends Component
{
    use WithFileUploads;

    public Community $comunidad, $miComunidad;
    public bool $openEditar = false;
    public $imagen;

    public function mount($id)
    {
        $this->comunidad = Community::findOrFail($id);
    }

    protected function rules(): array
    {
        // Valido los campos de la ventana modal para editar la comunidad.
        return [
            'miComunidad.nombre' => "",
            'miComunidad.descripcion' => ['required', 'string', 'min:10'],
            'miComunidad.privacidad' => ['required', 'in:PRIVADO,PUBLICO'],
            'miComunidad.imagen' => ['required', 'image', 'max:2048'],
        ];
    }

    public function render()
    {
        // Obtengo la comunidad que quiero visualizar.
        $comunidad = Community::where('id', $this->comunidad->id)->first();
        $this->comunidad = $comunidad;

        // Obtengo la id de la comunidad.
        $community_id = $comunidad->id;

        // Obtengo al creador de la comunidad
        $creador = User::where('id', $comunidad->user_id)->first();

        // Obtengo la id del usuario con el que estas autenticado.
        $user_id = auth()->user()->id;

        // Compruebo si el usuario autenticado pertenece o no a la comunidad aux sera true en caso de que si y sera false en caso de que no.
        $aux = User::whereHas('communities', function ($query) use ($community_id) {
            $query->where('communities.id', $community_id);
        })->where('id', $user_id)->exists();
        return view('livewire.show-community', compact('comunidad', 'creador', 'aux'));
    }

    public function borrarComunidad()
    {
        // Compruebo que tengas permiso para borrar la comunidad.
        self::comprobarPermisosComunidad($this->comunidad);

        // Obtengo los usuarios para borrarlos.
        $usuarios = $this->comunidad->users;
        foreach ($usuarios as $usuario) {
            self::quitarParticipante($usuario);
        }

        // Borro la imagen de la comunidad de la carpeta.
        Storage::delete($this->comunidad->imagen);

        // Borro la comunidad.
        $this->comunidad->delete();
        return redirect()->route('communities.show');
    }

    public function sacarParticipante(User $participante)
    {
        // Compruebo que el usuario que sale es con el que estas autenticado, es administrador o es dueño de la comunidad.
        self::comprobarUsuario();
        // Elimino al participante deseado
        self::quitarParticipante($participante);
        $this->emit('info', "Participante " . $participante->name . " ha salido");
    }

    private function quitarParticipante(User $participante) // Agregar borrar likes, comentarios y guardados al sacar al participante.
    {
        // Obtengo la id del participante y de la comunidad.
        $userId = $participante->id;
        $communityId = $this->comunidad->id;

        // Obtengo las publicaciones del participante que pertenecen a la comunidad de la que van a salir.
        $publicaciones = Publication::whereHas('community', function ($query) use ($communityId) {
            $query->where('id', $communityId);
        })->where('user_id', $userId)->get();

        // Borro las publicaciones del usuario y la imagen.
        foreach ($publicaciones as $publicacion) {
            Storage::delete($publicacion->imagen);
            $publicacion->delete();
        }

        // Elimino los comentarios, likes y saves del participante
        $publicaciones = $this->comunidad->publications;
        foreach ($publicaciones as $publicacion) {
            $like = Like::where('user_id', $userId)
                ->where('publication_id', $publicacion->id)
                ->first();
            $save = Save::where('user_id', $userId)
                ->where('publication_id', $publicacion->id)
                ->first();
            $comment = Comment::where('user_id', $userId)
                ->where('publication_id', $publicacion->id)
                ->first();
            if ($like) $like->delete();
            if ($save) $save->delete();
            if ($comment) $comment->delete();
        }

        // Saco al usuario de la comunidad Borrandolo de la base de datos.
        $participante->communities()->detach($this->comunidad->id);
    }

    public function meterParticipante()
    {
        // Obtengo al usuario autenticado.
        $user = auth()->user();
        if ($this->comunidad->privacidad == "PRIVADO") {
            Request::create([
                'user_id' => auth()->user()->id,
                'community_id' => $this->comunidad->id,
            ]);
            $this->emit('info', "Solicitud para participar en la comunidad enviada");
        } else {
            // Añado el usuario a la comunidad.
            // Da error en codigo, pero lo hace bien, no saltan excepciones.
            $user->communities()->attach($this->comunidad);
            $this->emit('info', "Participante " . $user->name . " ha entrado");
        }
    }

    public function editar()
    {
        // Compruebo que puedas editar la comunidad pasada.
        self::comprobarPermisosComunidad($this->comunidad);
        $this->miComunidad = $this->comunidad;
        $this->openEditar = true;
    }

    public function update()
    {
        // valido los campos de la ventana modal de editar la comunidad.
        $this->validate([
            'miComunidad.nombre' => ['required', 'string', 'min:3', 'unique:communities,nombre,' . $this->comunidad->id]
        ]);
        // Si has cambiado la imagen, borro la antigua y la sustituyo por la nueva.
        if ($this->imagen) {
            Storage::delete($this->comunidad->imagen);
            $this->comunidad->imagen = $this->imagen->store('imagenesComunidad');
        }
        // Cambio todos los campos de la comunidad
        $this->miComunidad->update([
            "nombre" => $this->miComunidad->nombre,
            "descripcion" => $this->miComunidad->descripcion,
            "imagen" => $this->comunidad->imagen,
            "privacidad" => $this->miComunidad->privacidad,
        ]);
        // Reseteo la variable.
        $this->miComunidad = new Community();
        $this->reset('openEditar');
        $this->emit('info', 'Comunidad editada con éxito');
    }

    public function comprobarPermisosComunidad(Community $comunidad)
    {
        // Compruebo que seas administrador o el dueño de la comunidad.
        if (auth()->user()->is_admin) return;
        if ($comunidad->user_id == auth()->user()->id) return;
        abort(404);
    }

    public function buscarUsuario($id)
    {
        return redirect()->route('perfiluser.show', compact('id'));
    }

    public function verPublicacionesComunidad()
    {
        $id = $this->comunidad->id;
        return redirect()->route('publicationscommunity.show', compact('id'));
    }

    public function comprobarUsuario()
    {
        // Compruebo que seas administrador o el dueño de la comunidad, 
        if (auth()->user()->is_admin) return;
        if ($this->comunidad->user_id == auth()->user()->id) return;
        foreach ($this->comunidad->users as $usuario) {
            if ($usuario->id == auth()->user()->id) return;
        }
        abort(404);
    }
}
