<?php

namespace App\Http\Livewire;

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
        // Vista como usuario normal (Publicaciones que puede ver el usuario autenticado, relacion con estado=>['PUBLICADO','BORRADOR'] y comunidades comunes)
        // Vista como usuario administrador y ver tus propias publicaciones (Todas las publicaciones del usuario) 
        if ($this->usuario->id != auth()->user()->id && !auth()->user()->is_admin) {
            // Primera vista mencionada
            // 
            if (trim($this->buscar)) {
                //si quieres buscar alguna publicacion, lo mostrare ordenado por id.
                $publicaciones = Publication::query()
                    ->where('user_id', $this->usuario->id)
                    ->where('estado', 'PUBLICADO')
                    ->where(function ($query) {
                        $query->whereIn('community_id', auth()->user()->communities->pluck('id'))
                            ->orWhereNull('community_id');
                    })
                    ->where(function ($q) {
                        $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                            ->orWhere('contenido', 'like', '%' . trim($this->buscar) . '%');
                    })
                    ->orderBy('id', 'desc')
                    ->paginate(15);
            } else {
                switch ($this->campo) {
                        // Obtengo las publicaciones del usuario.
                        // Obtengo las publicaciones con el estado en PUBLICADO.
                        // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco y de los que no pertenecen a comunidades
                        // de las demas comunidades.
                        // Lo ordeno por el titulo de las publicaciones.
                    case "titulo":
                        $publicaciones = Publication::where('user_id', $this->usuario->id)
                            ->where('estado', 'PUBLICADO')
                            ->where(function ($query) {
                                $query->whereIn('community_id', auth()->user()->communities->pluck('id'))
                                    ->orWhereNull('community_id');
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
                        $publicaciones = Publication::where('user_id', $this->usuario->id)
                            ->where('estado', 'PUBLICADO')
                            ->where(function ($query) {
                                $query->whereIn('community_id', auth()->user()->communities->pluck('id'))
                                    ->orWhereNull('community_id');
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
                        $publicaciones = Publication::where('user_id', $this->usuario->id)
                            ->where('estado', 'PUBLICADO')
                            ->where(function ($query) {
                                $query->whereIn('community_id', auth()->user()->communities->pluck('id'))
                                    ->orWhereNull('community_id');
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
                        $publicaciones = Publication::where('publications.user_id', $this->usuario->id)
                            ->where('estado', 'PUBLICADO')
                            ->where(function ($query) {
                                $query->whereIn('community_id', auth()->user()->communities->pluck('id'))
                                    ->orWhereNull('community_id');
                            })
                            ->join('likes', 'publications.id', 'likes.publication_id') // Unir la tabla likes a la consulta.
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
                        $publicaciones = Publication::where('user_id', $this->usuario->id)
                            ->where('estado', 'PUBLICADO')
                            ->where(function ($query) {
                                $query->whereIn('community_id', auth()->user()->communities->pluck('id'))
                                    ->orWhereNull('community_id');
                            })
                            ->orderBy('id', $this->orden)
                            ->paginate(15);
                        break;
                }
            }
        } else {
            if (trim($this->buscar)) {
                //si quieres buscar alguna publicacion, lo mostrare ordenado por id
                $publicaciones = Publication::query()
                    ->where('user_id', $this->usuario->id)
                    ->where(function ($q) {
                        $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                            ->orWhere('contenido', 'like', '%' . trim($this->buscar) . '%');
                    })
                    ->orderBy('id', 'desc')
                    ->paginate(15);
            } else {
                switch ($this->campo) {
                        // Obtengo las publicaciones del usuario.
                        // Lo ordeno por el titulo de las publicaciones.
                    case "titulo":
                        $publicaciones = Publication::where('user_id', $this->usuario->id)
                            ->orderBy('titulo', $this->orden)
                            ->paginate(15);
                        break;
                    case "creacion":
                        // Obtengo las publicaciones del usuario.
                        // Lo ordeno por la id de las publicaciones.
                        $publicaciones = Publication::where('user_id', $this->usuario->id)
                            ->orderBy('id', $this->orden)
                            ->paginate(15);
                        break;
                    case "comunidades":
                        // Obtengo las publicaciones del usuario.
                        // Lo ordeno por la id de las comunidades.
                        $publicaciones = Publication::where('user_id', $this->usuario->id)
                            ->orderBy("community_id", $this->orden)
                            ->paginate(15);
                        break;
                    case "likes":
                        // Obtengo las publicaciones del usuario.
                        // Obtengo cuantos likes tiene cada publicacion.
                        // Agrego la agrupación para evitar resultados duplicados.
                        // Ordeno por la cantidad de likes.
                        $publicaciones = Publication::where('publications.user_id', $this->usuario->id)
                            ->join('likes', 'publications.id', 'likes.publication_id') // Unir la tabla likes a la consulta.
                            ->selectRaw('publications.*, COUNT(likes.id) as likes_count')
                            ->groupBy('publications.id')
                            ->orderBy('likes_count', $this->orden)
                            ->paginate(15);
                        break;
                    default:
                        // Obtengo las publicaciones del usuario.
                        // Lo ordeno por la id de las publicaciones.
                        $publicaciones = Publication::where('user_id', $this->usuario->id)
                            ->orderBy('id', 'desc')
                            ->paginate(15);
                        break;
                }
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
}
