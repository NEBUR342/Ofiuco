<?php

namespace App\Http\Livewire;

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
        // Obtener todas las comunidades a las que pertenece el usuario autenticado
        $usuarioAutenticado = auth()->user();
        $comunidades = $usuarioAutenticado->communities;
        switch ($this->campo) {
            case "nombre":
                // Obtener las publicaciones de esos usuarios y ordenarlas por el nombre de los usuarios
                $publicaciones = Publication::whereIn('community_id', $comunidades->pluck('id'))
                    ->join('users', 'publications.user_id', '=', 'users.id') // Unir la tabla users a la consulta
                    ->where('estado', 'PUBLICADO')
                    ->orderBy('users.name', $this->orden)
                    ->paginate(15);
                break;
            case "creacion":
                $publicaciones = Publication::with('community')
                    ->whereHas('community.users', function ($query) use ($usuarioAutenticado) {
                        $query->where('user_id', $usuarioAutenticado->id);
                    })
                    ->where('estado', 'PUBLICADO')
                    ->orderBy('id', $this->orden)
                    ->paginate(15);
                break;
            case "comunidades":
                $publicaciones = Publication::with('community')
                    ->whereHas('community.users', function ($query) use ($usuarioAutenticado) {
                        $query->where('user_id', $usuarioAutenticado->id);
                    })
                    ->where('estado', 'PUBLICADO')
                    ->orderBy('community_id', $this->orden)
                    ->paginate(15);
                break;
            case "likes":
                $publicaciones = Publication::with('community')
                    ->leftJoin('likes', 'publications.id', 'likes.publication_id')
                    ->selectRaw('publications.*, COUNT(likes.id) as likes_count')
                    ->whereHas('community.users', function ($query) use ($usuarioAutenticado) {
                        $query->where('users.id', $usuarioAutenticado->id);
                    })
                    ->where('estado', 'PUBLICADO')
                    ->groupBy('publications.id') // Agregar la agrupación para evitar resultados duplicados
                    ->orderBy('likes_count', $this->orden, $this->orden) // Ordenar por cantidad de likes descendente
                    ->paginate(15);
                break;
            default:
                $publicaciones = Publication::whereIn('community_id', $comunidades->pluck('id'))
                    ->where(function ($q) {
                        $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                            ->orWhere('contenido', 'like', '%' . trim($this->buscar) . '%')
                            ->orWhereHas('user', function ($subQuery) {
                                $subQuery->where('name', 'like', '%' . trim($this->buscar) . '%');
                            })
                            ->orWhereHas('community', function ($subQuery) {
                                $subQuery->where('nombre', 'like', '%' . trim($this->buscar) . '%');
                            });
                    })
                    ->where('estado', 'PUBLICADO')
                    ->orderBy('id', 'desc')
                    ->paginate(15);
        }
        return view('livewire.show-publicationscommunities', compact('publicaciones'));
    }

    public function ordenar(string $campo)
    {
        $this->orden = ($this->orden == 'asc') ? 'desc' : 'asc';
        $this->campo = $campo;
    }

    public function verPublicacion($id){
        return redirect()->route('publication.show', compact('id'));
    }
}
