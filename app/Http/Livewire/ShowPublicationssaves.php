<?php

namespace App\Http\Livewire;

use App\Models\{Publication, Save, User, Tag};
use Livewire\{Component, WithPagination};

class ShowPublicationssaves extends Component {
    use WithPagination;

    public string $campo = 'creacion', $orden = 'desc', $buscar = "";
    public $etiqueta=0;
    public User $usuario;

    public function updatingBuscar() {
        $this->resetPage();
    }

    public function mount($id) {
        $this->usuario = User::findOrFail($id);
    }

    public function render() {
        $user = User::where('id', $this->usuario->id)->first();
        if(!auth()->user()->is_admin && auth()->user()->id!=$user->id) abort(404);
        // Uso este metodo para evitar que me introduzcan campos indevidos desde el "inspeccionar".
        // Considero que es una forma mas segura que introducir directamente los nombre de las columnas de las tablas.
        if (auth()->user()->is_admin) {
            switch ($this->campo) {
                case "nombre":
                    // Obtengo las publicaciones independientemente esten publicadas o no.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Lo ordeno por el nombre de los usuarios.
                    if($this->etiqueta){
                        $publicaciones = Publication::query()
                        ->whereIn('id', Save::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                })
                                ->orWhereHas('community', function ($q) {
                                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->whereHas('tags', function ($q) {
                            $q->where('tags.id', $this->etiqueta);
                        })
                        ->orderBy('titulo', $this->orden)
                        ->paginate(15);
                    }else{
                        $publicaciones = Publication::query()
                        ->whereIn('id', Save::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                })
                                ->orWhereHas('community', function ($q) {
                                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->orderBy('titulo', $this->orden)
                        ->paginate(15);
                    }
                    
                       
                    break;
                case "creacion":
                    // Obtengo las publicaciones independientemente esten publicadas o no.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Lo ordeno por el id de las publicaciones.
                    if($this->etiqueta){
                        $publicaciones = Publication::query()
                        ->whereIn('id', Save::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                })
                                ->orWhereHas('community', function ($q) {
                                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->whereHas('tags', function ($q) {
                            $q->where('tags.id', $this->etiqueta);
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
                    }else{
                        $publicaciones = Publication::query()
                        ->whereIn('id', Save::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                })
                                ->orWhereHas('community', function ($q) {
                                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
                    }
                    
                    break;
                case "comunidades":
                    // Obtengo las publicaciones independientemente esten publicadas o no.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Lo ordeno por el id de las comunidades.
                    if($this->etiqueta){
                        $publicaciones = Publication::query()
                        ->whereIn('id', Save::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                })
                                ->orWhereHas('community', function ($q) {
                                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->whereHas('tags', function ($q) {
                            $q->where('tags.id', $this->etiqueta);
                        })
                        ->orderBy('community_id', $this->orden)
                        ->paginate(15);
                    }else{
                        $publicaciones = Publication::query()
                        ->whereIn('id', Save::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                })
                                ->orWhereHas('community', function ($q) {
                                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->orderBy('community_id', $this->orden)
                        ->paginate(15);
                    }
                    
                    break;
                case "likes":
                    // Obtengo las publicaciones independientemente esten publicadas o no.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Obtengo cuantos likes tiene cada publicacion.
                    // Agrego la agrupación para evitar resultados duplicados.
                    // Ordeno por la cantidad de likes.
                    if($this->etiqueta){
                        $publicaciones = Publication::query()
                        ->whereIn('publications.id', Save::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                })
                                ->orWhereHas('community', function ($q) {
                                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->whereHas('tags', function ($q) {
                            $q->where('tags.id', $this->etiqueta);
                        })
                        ->leftJoin('likes', 'publications.id', 'likes.publication_id')
                        ->selectRaw('publications.*, COUNT(likes.id) as likes_count')
                        ->groupBy('publications.id')
                        ->orderBy('likes_count', $this->orden)
                        ->paginate(15);
                    }else{
                        $publicaciones = Publication::query()
                        ->whereIn('publications.id', Save::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                })
                                ->orWhereHas('community', function ($q) {
                                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->leftJoin('likes', 'publications.id', 'likes.publication_id')
                        ->selectRaw('publications.*, COUNT(likes.id) as likes_count')
                        ->groupBy('publications.id')
                        ->orderBy('likes_count', $this->orden)
                        ->paginate(15);
                    }
                    
                    break;
                default:
                    // Obtengo las publicaciones independientemente esten publicadas o no.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Lo ordeno por id, ya que no se ha encontrado otra.
                    if($this->etiqueta){
                        $publicaciones = Publication::query()
                        ->whereIn('publications.id', Save::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                })
                                ->orWhereHas('community', function ($q) {
                                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->whereHas('tags', function ($q) {
                            $q->where('tags.id', $this->etiqueta);
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
                    }else{
                        $publicaciones = Publication::query()
                        ->whereIn('publications.id', Save::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                })
                                ->orWhereHas('community', function ($q) {
                                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
                    }
                    
            }
        } else {
            switch ($this->campo) {
                case "nombre":
                    // Obtengo las publicaciones independientemente esten publicadas o no.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Lo ordeno por el nombre de los usuarios.
                    if($this->etiqueta){
                        $publicaciones = Publication::query()
                        ->where('estado', "PUBLICADO")
                        ->whereIn('id', Save::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                })
                                ->orWhereHas('community', function ($q) {
                                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->whereHas('tags', function ($q) {
                            $q->where('tags.id', $this->etiqueta);
                        })
                        ->orderBy('titulo', $this->orden)
                        ->paginate(15);
                    }else{
                        $publicaciones = Publication::query()
                        ->where('estado', "PUBLICADO")
                        ->whereIn('id', Save::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                })
                                ->orWhereHas('community', function ($q) {
                                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->orderBy('titulo', $this->orden)
                        ->paginate(15);
                    }
                    
                    break;
                case "creacion":
                    // Obtengo las publicaciones independientemente esten publicadas o no.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Lo ordeno por el id de las publicaciones.
                    if($this->etiqueta){
                        $publicaciones = Publication::query()
                        ->where('estado', "PUBLICADO")
                        ->whereIn('publications.id', Save::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                })
                                ->orWhereHas('community', function ($q) {
                                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->whereHas('tags', function ($q) {
                            $q->where('tags.id', $this->etiqueta);
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
                    }else{
                        $publicaciones = Publication::query()
                        ->where('estado', "PUBLICADO")
                        ->whereIn('publications.id', Save::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                })
                                ->orWhereHas('community', function ($q) {
                                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
                    }
                    
                    break;
                case "comunidades":
                    // Obtengo las publicaciones independientemente esten publicadas o no.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Lo ordeno por el id de las comunidades.
                    if($this->etiqueta){
                        $publicaciones = Publication::query()
                        ->where('estado', "PUBLICADO")
                        ->whereIn('id', Save::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                })
                                ->orWhereHas('community', function ($q) {
                                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->whereHas('tags', function ($q) {
                            $q->where('tags.id', $this->etiqueta);
                        })
                        ->orderBy('community_id', $this->orden)
                        ->paginate(15);
                    }else{
                        $publicaciones = Publication::query()
                        ->where('estado', "PUBLICADO")
                        ->whereIn('id', Save::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                })
                                ->orWhereHas('community', function ($q) {
                                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->orderBy('community_id', $this->orden)
                        ->paginate(15);
                    }
                    
                    break;
                case "likes":
                    // Obtengo las publicaciones independientemente esten publicadas o no.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Obtengo cuantos likes tiene cada publicacion.
                    // Agrego la agrupación para evitar resultados duplicados.
                    // Ordeno por la cantidad de likes.
                    if($this->etiqueta){
                        $publicaciones = Publication::query()
                        ->where('estado', "PUBLICADO")
                        ->whereIn('publications.id', Save::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                })
                                ->orWhereHas('community', function ($q) {
                                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->whereHas('tags', function ($q) {
                            $q->where('tags.id', $this->etiqueta);
                        })
                        ->leftJoin('likes', 'publications.id', 'likes.publication_id')
                        ->selectRaw('publications.*, COUNT(likes.id) as likes_count')
                        ->groupBy('publications.id')
                        ->orderBy('likes_count', $this->orden)
                        ->paginate(15);
                    }else{
                        $publicaciones = Publication::query()
                        ->where('estado', "PUBLICADO")
                        ->whereIn('publications.id', Save::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                })
                                ->orWhereHas('community', function ($q) {
                                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->leftJoin('likes', 'publications.id', 'likes.publication_id')
                        ->selectRaw('publications.*, COUNT(likes.id) as likes_count')
                        ->groupBy('publications.id')
                        ->orderBy('likes_count', $this->orden)
                        ->paginate(15);
                    }
                    
                    break;
                default:
                    // Obtengo las publicaciones independientemente esten publicadas o no.
                    // Divide las publicaciones que pertenecen a las comunidades a las que yo pertenezco de las demas comunidades
                    // y de los que no pertenecen a comunidades.
                    // Lo ordeno por id, ya que no se ha encontrado otra.
                    if($this->etiqueta){
                        $publicaciones = Publication::query()
                        ->where('estado', "PUBLICADO")
                        ->whereIn('publications.id', Save::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                })
                                ->orWhereHas('community', function ($q) {
                                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->whereHas('tags', function ($q) {
                            $q->where('tags.id', $this->etiqueta);
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
                    }else{
                        $publicaciones = Publication::query()
                        ->where('estado', "PUBLICADO")
                        ->whereIn('publications.id', Save::where('user_id', $user->id)->pluck('publication_id'))
                        ->where(function ($q) {
                            $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . trim($this->buscar) . '%');
                                })
                                ->orWhereHas('community', function ($q) {
                                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%');
                                });
                        })
                        ->orderBy('id', $this->orden)
                        ->paginate(15);
                    }
            }
        }
        $comunidades = true;
        $etiquetas = Tag::get();
        return view('livewire.show-publications', compact('publicaciones', 'comunidades', 'etiquetas'));
    }

    public function ordenar(string $campo) {
        $this->orden = ($this->orden == 'asc') ? 'desc' : 'asc';
        $this->campo = $campo;
    }

    public function verPublicacion($id) {
        return redirect()->route('publication.show', compact('id'));
    }

    public function buscarEtiqueta($id) {
        $this->etiqueta=$id;
    }
}
