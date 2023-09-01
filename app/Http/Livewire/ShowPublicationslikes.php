<?php

namespace App\Http\Livewire;

use App\Models\Community;
use App\Models\Like;
use App\Models\Publication;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPublicationslikes extends Component
{
    use WithPagination;

    public string $campo = 'creacion', $orden = 'desc', $buscar = "";
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
        $user = User::where('id', $this->usuario->id)->first();
        $comunidades = $user->communities;
        // if (!auth()->user()->is_admin && $user->id != auth()->user()->id) abort(404);
        // Uso este metodo para evitar que me introduzcan campos indevidos desde el "inspeccionar".
        // Considero que es una forma mas segura que introducir directamente los nombre de las columnas de las tablas.
        if (auth()->user()->is_admin) {
            switch ($this->campo) {
                case "nombre":
                    // Obtengo las publicaciones independientemente esten publicadas o no.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Lo ordeno por el nombre de los usuarios.
                    $publicaciones = Publication::query()
                        ->whereIn('id', Like::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%');
                        })
                        ->orderBy('titulo', $this->orden)
                        ->paginate(15);
                    break;
                case "creacion":
                    // Obtengo las publicaciones independientemente esten publicadas o no.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Lo ordeno por el id de las publicaciones.
                    $publicaciones = Publication::query()
                        ->whereIn('id', Like::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%');
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
                    break;
                case "comunidades":
                    // Obtengo las publicaciones independientemente esten publicadas o no.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Lo ordeno por el id de las comunidades.
                    $publicaciones = Publication::query()
                        ->whereIn('id', Like::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%');
                        })
                        ->orderBy('community_id', $this->orden)
                        ->paginate(15);
                    break;
                case "likes":
                    // Obtengo las publicaciones independientemente esten publicadas o no.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Obtengo cuantos likes tiene cada publicacion.
                    // Agrego la agrupación para evitar resultados duplicados.
                    // Ordeno por la cantidad de likes.
                    $publicaciones = Publication::query()
                        ->whereIn('publications.id', Like::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%');
                        })
                        ->leftJoin('likes', 'publications.id', 'likes.publication_id')
                        ->selectRaw('publications.*, COUNT(likes.id) as likes_count')
                        ->groupBy('publications.id')
                        ->orderBy('likes_count', $this->orden)
                        ->paginate(15);
                    break;
                default:
                    // Obtengo las publicaciones independientemente esten publicadas o no.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Lo ordeno por id, ya que no se ha encontrado otra.
                    $publicaciones = Publication::query()
                        ->whereIn('id', Like::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%');
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
            }
        } else {
            switch ($this->campo) {
                case "nombre":
                    // Obtengo las publicaciones con el estado en PUBLICADO.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Lo ordeno por el nombre de los usuarios.
                    $publicaciones = Publication::query()
                        ->where('estado', 'PUBLICADO')
                        ->where(function ($query) use ($comunidades) {
                            $query->whereIn('community_id', $comunidades->pluck('id'))
                                ->orWhereIn('community_id', Community::where('user_id', auth()->user()->id)->pluck('id'));
                        })
                        ->whereIn('id', Like::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%');
                        })
                        ->orderBy('titulo', $this->orden)
                        ->paginate(15);
                    break;
                case "creacion":
                    // Obtengo las publicaciones con el estado en PUBLICADO.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Lo ordeno por el id de las publicaciones.
                    $publicaciones = Publication::query()
                        ->where('estado', 'PUBLICADO')
                        ->where(function ($query) use ($comunidades) {
                            $query->whereIn('community_id', $comunidades->pluck('id'))
                                ->orWhereIn('community_id', Community::where('user_id', auth()->user()->id)->pluck('id'));
                        })
                        ->whereIn('id', Like::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%');
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
                    break;
                case "comunidades":
                    // Obtengo las publicaciones con el estado en PUBLICADO.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Lo ordeno por el id de las comunidades.
                    $publicaciones = Publication::query()
                        ->where('estado', 'PUBLICADO')
                        ->where(function ($query) use ($comunidades) {
                            $query->whereIn('community_id', $comunidades->pluck('id'))
                                ->orWhereIn('community_id', Community::where('user_id', auth()->user()->id)->pluck('id'));
                        })
                        ->whereIn('id', Like::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%');
                        })
                        ->orderBy('community_id', $this->orden)
                        ->paginate(15);
                    break;
                case "likes":
                    // Obtengo las publicaciones con el estado en PUBLICADO.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Obtengo cuantos likes tiene cada publicacion.
                    // Agrego la agrupación para evitar resultados duplicados.
                    // Ordeno por la cantidad de likes.
                    $publicaciones = Publication::query()
                        ->where('estado', 'PUBLICADO')
                        ->where(function ($query) use ($comunidades) {
                            $query->whereIn('community_id', $comunidades->pluck('id'))
                                ->orWhereIn('community_id', Community::where('user_id', auth()->user()->id)->pluck('id'));
                        })
                        ->whereIn('publications.id', Like::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%');
                        })
                        ->leftJoin('likes', 'publications.id', 'likes.publication_id')
                        ->selectRaw('publications.*, COUNT(likes.id) as likes_count')
                        ->groupBy('publications.id')
                        ->orderBy('likes_count', $this->orden)
                        ->paginate(15);
                    break;
                default:
                    // Obtengo las publicaciones con el estado en PUBLICADO.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Lo ordeno por id, ya que no se ha encontrado otra.
                    $publicaciones = Publication::query()
                        ->where('estado', 'PUBLICADO')
                        ->where(function ($query) use ($comunidades) {
                            $query->whereIn('community_id', $comunidades->pluck('id'))
                                ->orWhereIn('community_id', Community::where('user_id', auth()->user()->id)->pluck('id'));
                        })
                        ->whereIn('id', Like::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%');
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
            }
        }
        return view('livewire.show-publicationslikes', compact('publicaciones'));
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
