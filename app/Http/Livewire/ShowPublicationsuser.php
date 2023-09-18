<?php

namespace App\Http\Livewire;

use App\Models\Community;
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

    public function updating()
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
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhere('contenido', 'like', '%' . trim($this->buscar) . '%');
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
        return view('livewire.show-publicationsuser', compact('publicaciones', 'tags'));
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

    public function buscarLikesUsuario()
    {
        $id=$this->usuario->id;
        return redirect()->route('publicationslikes.show', compact('id'));
    }
}
