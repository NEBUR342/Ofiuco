<?php

namespace App\Http\Livewire;

use App\Models\Community;
use App\Models\Publication;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPublicationscommunities extends Component
{
    use WithPagination;

    public string $campo = 'id', $orden = 'desc', $buscar = "";

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Obtener todas las comunidades a las que pertenece el usuario autenticado.
        $usuarioAutenticado = auth()->user();
        $comunidades = $usuarioAutenticado->communities;
        if (trim($this->buscar)) {
            //si quieres buscar alguna publicacion, lo mostrare ordenado por id.
            $publicaciones = Publication::query()
                ->where('estado', 'PUBLICADO')
                ->where(function ($query) use ($comunidades) {
                    $query->whereIn('community_id', $comunidades->pluck('id'))
                        ->orWhereIn('community_id', Community::where('user_id', auth()->user()->id)->pluck('id'));
                })
                ->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                })
                ->orderBy('id', 'desc')
                ->paginate(15);
        } else {
            // Uso este metodo para evitar que me introduzcan campos indevidos desde el "inspeccionar".
            // Considero que es una forma mas segura que introducir directamente los nombre de las columnas de las tablas.
            switch ($this->campo) {
                case "nombre":
                    // Obtengo las publicaciones con el estado en PUBLICADO.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Lo ordeno por el nombre de los usuarios.
                    $publicaciones = Publication::where('estado', 'PUBLICADO')
                        ->whereIn('community_id', $comunidades->pluck('id'))
                        ->orWhereIn('community_id', Community::where('user_id', auth()->user()->id)->pluck('id'))
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
                    break;
                case "creacion":
                    // Obtengo las publicaciones con el estado en PUBLICADO.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Lo ordeno por el id de las publicaciones.
                    $publicaciones = Publication::where('estado', 'PUBLICADO')
                        ->whereIn('community_id', $comunidades->pluck('id'))
                        ->orWhereIn('community_id', Community::where('user_id', auth()->user()->id)->pluck('id'))
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
                    break;
                case "comunidades":
                    // Obtengo las publicaciones con el estado en PUBLICADO.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Lo ordeno por el id de las comunidades.
                    $publicaciones = Publication::where('estado', 'PUBLICADO')
                        ->whereIn('community_id', $comunidades->pluck('id'))
                        ->orWhereIn('community_id', Community::where('user_id', auth()->user()->id)->pluck('id'))
                        ->where('estado', 'PUBLICADO')
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
                    $publicaciones = Publication::where('estado', 'PUBLICADO')
                        ->where(function ($query) use ($comunidades) {
                            $query->whereIn('community_id', $comunidades->pluck('id'))
                                ->orWhereIn('community_id', Community::where('user_id', auth()->user()->id)->pluck('id'));
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
                    $publicaciones = Publication::where('estado', 'PUBLICADO')
                        ->where(function ($query) use ($comunidades) {
                            $query->whereIn('community_id', $comunidades->pluck('id'))
                                ->orWhereIn('community_id', Community::where('user_id', auth()->user()->id)->pluck('id'));
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
            }
        }
        return view('livewire.show-publicationscommunities', compact('publicaciones'));
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
