<?php

namespace App\Http\Livewire;

use App\Models\Publication;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;

class ShowPublicationswelcome extends Component
{
    use WithPagination;

    public string $campo = 'creacion', $orden = 'desc', $buscar = "";
    public bool $otravista = false;

    public function updatingBuscar()
    {
        $this->resetPage();
    }
    // Muestro las publicaciones que no pertenecen a ninguna comunidad
    public function render()
    {
        $vistaLogueado = false;
        if (auth()->user()) {
            $vistaLogueado = true;
            $usuario = auth()->user();
        }
        if ($vistaLogueado && $this->otravista) {
            switch ($this->campo) {
                case "nombre":
                    // Obtengo las publicaciones con el estado en PUBLICADO.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Lo ordeno por el nombre de los usuarios.
                    $publicaciones = Publication::query()
                        ->where('estado', 'PUBLICADO')
                        ->where('comunidad', 'NO')
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->whereIn('user_id', function ($query) use ($usuario) {
                            $query->select('user_id')
                                ->from('follows')
                                ->where('seguidor_id', $usuario->id)
                                ->where('aceptado', 'SI');
                        })
                        ->groupBy('publications.id')
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
                        ->where('comunidad', 'NO')
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->whereIn('user_id', function ($query) use ($usuario) {
                            $query->select('user_id')
                                ->from('follows')
                                ->where('seguidor_id', $usuario->id)
                                ->where('aceptado', 'SI');
                        })
                        ->groupBy('publications.id')
                        ->orderBy('id', $this->orden)
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
                        ->where('comunidad', 'NO')
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->whereIn('publications.user_id', function ($query) use ($usuario) {
                            $query->select('follows.user_id')
                                ->from('follows')
                                ->where('seguidor_id', $usuario->id)
                                ->where('aceptado', 'SI');
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
                        ->where('comunidad', 'NO')
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->whereIn('user_id', function ($query) use ($usuario) {
                            $query->select('user_id')
                                ->from('follows')
                                ->where('seguidor_id', $usuario->id)
                                ->where('aceptado', 'SI');
                        })
                        ->groupBy('publications.id')
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
                        ->where('comunidad', 'NO')
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->whereIn('user_id', function ($query) {
                            $query->select('id')
                                ->from('users')
                                ->where('privado', 0);
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
                        ->where('comunidad', 'NO')
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%');
                        })
                        ->whereIn('user_id', function ($query) {
                            $query->select('id')
                                ->from('users')
                                ->where('privado', 0);
                        })
                        ->orderBy('id', $this->orden)
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
                        ->where('comunidad', 'NO')
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->whereIn('publications.user_id', function ($query) {
                            $query->select('id')
                                ->from('users')
                                ->where('privado', 0);
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
                        ->where('comunidad', 'NO')
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->whereIn('user_id', function ($query) {
                            $query->select('id')
                                ->from('users')
                                ->where('privado', 0);
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
            }
        }
        $comunidades = false;
        $otravista = $this->otravista;
        return view('livewire.show-publications', compact('publicaciones', 'comunidades', 'otravista'));
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
    
    public function cambiarvista()
    {
        if ($this->otravista) $this->otravista = false;
        else $this->otravista = true;
    }
}
