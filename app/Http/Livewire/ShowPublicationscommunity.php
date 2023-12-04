<?php
namespace App\Http\Livewire;

use App\Models\{Community, Publication};
use Livewire\{Component, WithPagination};

class ShowPublicationscommunity extends Component {
    use WithPagination;

    public Community $comunidad;
    public string $campo = 'creacion', $orden = 'desc', $buscar = "";

    public function updatingBuscar() {
        $this->resetPage();
    }

    public function mount($id) {
        $this->comunidad = Community::findOrFail($id);
    }

    public function render() {
        // Obtener todas las comunidades a las que pertenece el usuario autenticado.
        $comunidad = Community::where('id', $this->comunidad->id)->first();
        $this->comunidad = $comunidad;
        self::comprobarPermisosComunidad();
        // Uso este metodo para evitar que me introduzcan campos indevidos desde el "inspeccionar".
        // Considero que es una forma mas segura que introducir directamente los nombre de las columnas de las tablas.
        if ($comunidad->user_id == auth()->user()->id || auth()->user()->is_admin) {
            switch ($this->campo) {
                case "nombre":
                    // Obtengo las publicaciones con el estado en PUBLICADO.
                    // Obtengo las publicaciones que pertenecen a la comunidad seleccionada
                    // Lo ordeno por el nombre de los usuarios.
                    $publicaciones = Publication::query()
                        ->where('community_id', $comunidad->id)
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                              ->orWhereHas('user', function ($q) {
                                  $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                              });
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
                    break;
                case "creacion":
                    // Obtengo las publicaciones con el estado en PUBLICADO.
                    // Obtengo las publicaciones que pertenecen a la comunidad seleccionada
                    // Lo ordeno por el id de las publicaciones.
                    $publicaciones = Publication::query()
                        ->where('community_id', $comunidad->id)
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                              ->orWhereHas('user', function ($q) {
                                  $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                              });
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
                    break;
                case "likes":
                    // Obtengo las publicaciones con el estado en PUBLICADO.
                    // Obtengo las publicaciones que pertenecen a la comunidad seleccionada
                    // Obtengo cuantos likes tiene cada publicacion.
                    // Agrego la agrupación para evitar resultados duplicados.
                    // Ordeno por la cantidad de likes.
                    $publicaciones = Publication::query()
                        ->where('community_id', $comunidad->id)
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                              ->orWhereHas('user', function ($q) {
                                  $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                              });
                        })
                        ->leftJoin('likes', 'publications.id', 'likes.publication_id')
                        ->selectRaw('publications.*, COUNT(likes.id) as likes_count')
                        ->groupBy('publications.id')
                        ->orderBy('likes_count', $this->orden)
                        ->paginate(15);
                    break;
                default:
                    // Obtengo las publicaciones con el estado en PUBLICADO.
                    // Obtengo las publicaciones que pertenecen a la comunidad seleccionada
                    // Lo ordeno por id, ya que no se ha encontrado otra.
                    $publicaciones = Publication::query()
                        ->where('community_id', $comunidad->id)
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                              ->orWhereHas('user', function ($q) {
                                  $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                              });
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
            }
        } else {
            switch ($this->campo) {
                case "nombre":
                    // Obtengo las publicaciones con el estado en PUBLICADO.
                    // Obtengo las publicaciones que pertenecen a la comunidad seleccionada
                    // Lo ordeno por el nombre de los usuarios.
                    $publicaciones = Publication::query()
                        ->where('estado', 'PUBLICADO')
                        ->where('community_id', $comunidad->id)
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                              ->orWhereHas('user', function ($q) {
                                  $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                              });
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
                    break;
                case "creacion":
                    // Obtengo las publicaciones con el estado en PUBLICADO.
                    // Obtengo las publicaciones que pertenecen a la comunidad seleccionada
                    // Lo ordeno por el id de las publicaciones.
                    $publicaciones = Publication::query()
                        ->where('estado', 'PUBLICADO')
                        ->where('community_id', $comunidad->id)
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                              ->orWhereHas('user', function ($q) {
                                  $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                              });
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
                    break;
                case "likes":
                    // Obtengo las publicaciones con el estado en PUBLICADO.
                    // Obtengo las publicaciones que pertenecen a la comunidad seleccionada
                    // Obtengo cuantos likes tiene cada publicacion.
                    // Agrego la agrupación para evitar resultados duplicados.
                    // Ordeno por la cantidad de likes.
                    $publicaciones = Publication::query()
                        ->where('estado', 'PUBLICADO')
                        ->where('community_id', $comunidad->id)
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                              ->orWhereHas('user', function ($q) {
                                  $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                              });
                        })
                        ->leftJoin('likes', 'publications.id', 'likes.publication_id')
                        ->selectRaw('publications.*, COUNT(likes.id) as likes_count')
                        ->groupBy('publications.id')
                        ->orderBy('likes_count', $this->orden)
                        ->paginate(15);
                    break;
                default:
                    // Obtengo las publicaciones con el estado en PUBLICADO.
                    // Obtengo las publicaciones que pertenecen a la comunidad seleccionada
                    // Lo ordeno por id, ya que no se ha encontrado otra.
                    $publicaciones = Publication::query()
                        ->where('estado', 'PUBLICADO')
                        ->where('community_id', $comunidad->id)
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                              ->orWhereHas('user', function ($q) {
                                  $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                              });
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
            }
        }
        $comunidades=false;
        return view('livewire.show-publications', compact('publicaciones', 'comunidades'));
    }

    public function ordenar(string $campo) {
        $this->orden = ($this->orden == 'asc') ? 'desc' : 'asc';
        $this->campo = $campo;
    }

    public function verPublicacion($id) {
        return redirect()->route('publication.show', compact('id'));
    }

    // Compruebo que eres administrador, si perteneces a la comunidad o si es tuya.
    private function comprobarPermisosComunidad() {
        if (auth()->user()->is_admin) return;
        if ($this->comunidad->user_id == auth()->user()->id) return;
        foreach ($this->comunidad->users as $usuario) {
            if ($usuario->id == auth()->user()->id) return;
        }
        abort(404);
    }
}
