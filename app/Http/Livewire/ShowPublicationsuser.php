<?php

namespace App\Http\Livewire;

use App\Models\Community;
use App\Models\Follow;
use App\Models\Friend;
use App\Models\Publication;
use App\Models\Tag;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPublicationsuser extends Component
{
    use WithPagination;

    public string $campo = 'id', $orden = 'desc', $buscar = "";
    public User $usuario;

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function mount($id)
    {
        $this->usuario = User::findOrFail($id);
    }

    public function render()
    {
        // Voy a diferenciar dos:
        // Vista como usuario normal (Publicaciones que puede ver el usuario autenticado, relacion con estado=>['PUBLICADO','BORRADOR'] y comunidades comunes).
        // Vista como usuario administrador y ver tus propias publicaciones (Todas las publicaciones del usuario).
        if ($this->usuario->id != auth()->user()->id && !auth()->user()->is_admin) {
            // Primera vista mencionada.
            switch ($this->campo) {
                    // Obtengo las publicaciones del usuario.
                    // Obtengo las publicaciones con el estado en PUBLICADO.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco y de los que no pertenecen a comunidades
                    // de las demas comunidades.
                    // Lo ordeno por el titulo de las publicaciones.
                case "titulo":
                    $publicaciones = Publication::query()
                        ->where('user_id', $this->usuario->id)
                        ->where('estado', 'PUBLICADO')
                        ->where(function ($query) {
                            $query->whereIn('community_id', auth()->user()->communities->pluck('id'))
                                ->orWhereIn('community_id', Community::where('user_id', auth()->user()->id)->pluck('id'))
                                ->orWhereNull('community_id');
                        })
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%');
                        })
                        ->orderBy('titulo', $this->orden)
                        ->paginate(15);
                    break;
                case "creacion":
                    // Obtengo las publicaciones del usuario.
                    // Obtengo las publicaciones con el estado en PUBLICADO.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco y de los que no pertenecen a comunidades
                    // de las demas comunidades.
                    // Lo ordeno por el id de las publicaciones.
                    $publicaciones = Publication::query()
                        ->where('user_id', $this->usuario->id)
                        ->where('estado', 'PUBLICADO')
                        ->where(function ($query) {
                            $query->whereIn('community_id', auth()->user()->communities->pluck('id'))
                                ->orWhereIn('community_id', Community::where('user_id', auth()->user()->id)->pluck('id'))
                                ->orWhereNull('community_id');
                        })
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhere('contenido', 'like', '%' . trim($this->buscar) . '%');
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
                    break;
                case "comunidades":
                    // Obtengo las publicaciones del usuario.
                    // Obtengo las publicaciones con el estado en PUBLICADO.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco y de los que no pertenecen a comunidades
                    // de las demas comunidades.
                    // Lo ordeno por el id de las comunidades.
                    $publicaciones = Publication::query()
                        ->where('user_id', $this->usuario->id)
                        ->where('estado', 'PUBLICADO')
                        ->where(function ($query) {
                            $query->whereIn('community_id', auth()->user()->communities->pluck('id'))
                                ->orWhereIn('community_id', Community::where('user_id', auth()->user()->id)->pluck('id'))
                                ->orWhereNull('community_id');
                        })
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhere('contenido', 'like', '%' . trim($this->buscar) . '%');
                        })
                        ->orderBy("community_id", $this->orden)
                        ->paginate(15);
                    break;
                case "likes":
                    // Obtengo las publicaciones del usuario.
                    // Obtengo las publicaciones con el estado en PUBLICADO.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco y de los que no pertenecen a comunidades
                    // de las demas comunidades.
                    // Obtengo cuantos likes tiene cada publicacion.
                    // Agrego la agrupación para evitar resultados duplicados.
                    // Ordeno por la cantidad de likes.
                    $publicaciones = Publication::query()
                        ->where('publications.user_id', $this->usuario->id)
                        ->where('estado', 'PUBLICADO')
                        ->where(function ($query) {
                            $query->whereIn('community_id', auth()->user()->communities->pluck('id'))
                                ->orWhereIn('community_id', Community::where('user_id', auth()->user()->id)->pluck('id'))
                                ->orWhereNull('community_id');
                        })
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhere('contenido', 'like', '%' . trim($this->buscar) . '%');
                        })
                        ->leftJoin('likes', 'publications.id', 'likes.publication_id') // Unir la tabla likes a la consulta.
                        ->selectRaw('publications.*, COUNT(likes.id) as likes_count')
                        ->groupBy('publications.id')
                        ->orderBy('likes_count', $this->orden)
                        ->paginate(15);
                    break;
                default:
                    // Obtengo las publicaciones del usuario.
                    // Obtengo las publicaciones con el estado en PUBLICADO.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco y de los que no pertenecen a comunidades
                    // de las demas comunidades.
                    // Lo ordeno por el id de las publicaciones, ya que no se ha encontrado otra.
                    $publicaciones = Publication::query()
                        ->where('user_id', $this->usuario->id)
                        ->where('estado', 'PUBLICADO')
                        ->where(function ($query) {
                            $query->whereIn('community_id', auth()->user()->communities->pluck('id'))
                                ->orWhereIn('community_id', Community::where('user_id', auth()->user()->id)->pluck('id'))
                                ->orWhereNull('community_id');
                        })
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhere('contenido', 'like', '%' . trim($this->buscar) . '%');
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
                    break;
            }
        } else {
            // Segunda vista mencionada.
            switch ($this->campo) {
                    // Obtengo las publicaciones del usuario.
                    // Lo ordeno por el titulo de las publicaciones.
                case "titulo":
                    $publicaciones = Publication::query()
                        ->where('user_id', $this->usuario->id)
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhere('contenido', 'like', '%' . trim($this->buscar) . '%');
                        })
                        ->orderBy('titulo', $this->orden)
                        ->paginate(15);
                    break;
                case "creacion":
                    // Obtengo las publicaciones del usuario.
                    // Lo ordeno por la id de las publicaciones.
                    $publicaciones = Publication::query()
                        ->where('user_id', $this->usuario->id)
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhere('contenido', 'like', '%' . trim($this->buscar) . '%');
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
                    break;
                case "comunidades":
                    // Obtengo las publicaciones del usuario.
                    // Lo ordeno por la id de las comunidades.
                    $publicaciones = Publication::query()
                        ->where('user_id', $this->usuario->id)
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhere('contenido', 'like', '%' . trim($this->buscar) . '%');
                        })
                        ->orderBy("community_id", $this->orden)
                        ->paginate(15);
                    break;
                case "likes":
                    // Obtengo las publicaciones del usuario.
                    // Obtengo cuantos likes tiene cada publicacion.
                    // Agrego la agrupación para evitar resultados duplicados.
                    // Ordeno por la cantidad de likes.
                    $publicaciones = Publication::query()
                        ->where('publications.user_id', $this->usuario->id)
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhere('contenido', 'like', '%' . trim($this->buscar) . '%');
                        })
                        ->leftJoin('likes', 'publications.id', 'likes.publication_id')
                        ->selectRaw('publications.*, COUNT(likes.id) as likes_count')
                        ->groupBy('publications.id')
                        ->orderBy('likes_count', $this->orden)
                        ->orderBy('id', $this->orden) // Se ordenaran por id los que tienen la misma cantidad de likes.
                        ->paginate(15);
                    break;
                default:
                    // Obtengo las publicaciones del usuario.
                    // Lo ordeno por la id de las publicaciones.
                    $publicaciones = Publication::query()
                        ->where('user_id', $this->usuario->id)
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhere('contenido', 'like', '%' . trim($this->buscar) . '%');
                        })
                        ->orderBy('id', 'desc')
                        ->paginate(15);
                    break;
            }
        }
        $tags = Tag::pluck('nombre', 'id')->toArray();
        $usuario = $this->usuario;
        // Obtengo las comunidades en las que es participante.
        $comunidadesParticipado = $usuario->communities()->get();

        // Obtengo las comunidades en las que es el creador.
        $comunidadesCreador = Community::where('user_id', $usuario->id)->get();

        // obtengo si le sigue
        $follow = Follow::where('user_id', $usuario->id)
        ->where('seguidor_id', auth()->user()->id)
        ->count();
        return view('livewire.show-publicationsuser', compact('publicaciones', 'tags', 'usuario', 'comunidadesParticipado', 'comunidadesCreador', 'follow'));
    }

    public function ordenar(string $campo)
    {
        $this->orden = ($this->orden == 'asc') ? 'desc' : 'asc';
        $this->campo = $campo;
    }

    public function verPublicacion($id)
    {
        return redirect()->route('publication.show', compact('id'));
    }

    public function verComunidad($id)
    {
        return redirect()->route('community.show', compact('id'));
    }

    public function buscarLikesUsuario()
    {
        $id = $this->usuario->id;
        return redirect()->route('publicationslikes.show', compact('id'));
    }

    public function solicitudamigo()
    {
        $id=$this->usuario->id;
        // me aseguro de que no modifiquen desde la consola para repetir amigos
        $amigos = Friend::where("frienduno_id", auth()->user()->id)
            ->orwhere("frienddos_id", auth()->user()->id)
            ->get();
        if (auth()->user()->id == $id || ($amigos->contains('frienduno_id', $id) || $amigos->contains('frienddos_id', $id))) return;
        // pongo primero el usuario con id menor.
        // asi evito amigos duplicados
        if ($id > auth()->user()->id) {
            Friend::create([
                'user_id' => auth()->user()->id,
                'frienduno_id' => auth()->user()->id,
                'frienddos_id' => $id,
                'aceptado' => "NO"
            ]);
        } else {
            Friend::create([
                'user_id' => auth()->user()->id,
                'frienduno_id' => $id,
                'frienddos_id' => auth()->user()->id,
                'aceptado' => "NO"
            ]);
        }
        $this->emit('info', "Solicitud de amistad enviada");
    }

    public function borraramigo()
    {
        $id=$this->usuario->id;
        // me aseguro de que no modifiquen desde la consola para repetir amigos
        $amigo = Friend::where(function ($query) use ($id) {
            $query->where('frienduno_id', $id)
                ->orWhere('frienddos_id', $id);
        })
            ->where(function ($query) {
                $query->where('frienduno_id', auth()->user()->id)
                    ->orWhere('frienddos_id', auth()->user()->id);
            })
            ->first();
        if ($amigo && $amigo->aceptado == "SI") {
            $amigo->delete();
            $this->emit('info', "Amistad borrada");
        } elseif ($amigo && $amigo->aceptado == "NO") {
            $amigo->delete();
            $this->emit('info', "Solicitud de amistad borrada");
        }
    }

    public function follow()
    {
        if ($this->usuario->privado) {
            Follow::create([
                'user_id' => $this->usuario->id,
                'seguidor_id' => auth()->user()->id,
                'aceptado' => 'NO'
            ]);
        } else {
            Follow::create([
                'user_id' => $this->usuario->id,
                'seguidor_id' => auth()->user()->id,
                'aceptado' => 'NO'
            ]);
        }
    }
    public function followdestroy(){
        $follow=Follow::where('user_id',$this->usuario->id)->where('seguidor_id',auth()->user()->id)->first();
        $follow->delete();
    }
}
