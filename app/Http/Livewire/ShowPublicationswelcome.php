<?php

namespace App\Http\Livewire;

use App\Models\Publication;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;

class ShowPublicationswelcome extends Component {
    use WithPagination;
    public string $campo = 'creacion', $orden = 'desc', $buscar = "";
    public function updatingBuscar() {
        $this->resetPage();
    }
    // Muestro las publicaciones que no pertenecen a ninguna comunidad
    public function render() {
        // Borro la carpeta livewire-tmp ya que se genera al editar la foto de un usuario. Lo hago aqui ya que es la vista mas uasada.
        File::deleteDirectory(storage_path('app/public/livewire-tmp'));
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
                    ->where('comunidad', 'NO')
                    ->where(function ($q) {
                        $q->where('titulo', 'like', '%' . trim($this->buscar) . '%');
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
                    ->where('comunidad', 'NO')
                    ->where(function ($q) {
                        $q->where('titulo', 'like', '%' . trim($this->buscar) . '%');
                    })
                    ->orderBy('id', $this->orden)
                    ->paginate(15);
        }
        
        return view('livewire.show-publicationswelcome', compact('publicaciones'));
    }

    public function ordenar(string $campo) {
        $this->orden = ($this->orden == 'asc') ? 'desc' : 'asc';
        $this->campo = $campo;
    }

    public function verPublicacion($id) {
        return redirect()->route('publication.show', compact('id'));
    }
}
