<?php

namespace App\Http\Livewire;

use App\Models\Publication;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPublicationsuser extends Component
{
    use WithPagination;

    public string $campo = 'id', $orden = 'desc', $buscar = "";

    public function updating()
    {
        $this->resetPage();
    }

    public function render()
    {
        switch ($this->campo) {
            case "titulo":
                $publicaciones = Publication::where('user_id', auth()->user()->id)
                    ->orderBy('titulo', $this->orden)
                    ->paginate(15);
                break;
            case "creacion":
                $publicaciones = Publication::where('user_id', auth()->user()->id)
                    ->orderBy('id', $this->orden)
                    ->paginate(15);
                break;
            case "comunidades":
                $publicaciones = Publication::where('user_id', auth()->user()->id)
                    ->orderBy("community_id", $this->orden)
                    ->paginate(15);
                break;
            case "likes":
                $publicaciones = Publication::leftJoin('likes', 'publications.id', 'likes.publication_id')
                    ->selectRaw('publications.*, COUNT(likes.id) as likes_count')
                    ->where('publications.user_id', auth()->user()->id)
                    ->groupBy('publications.id')
                    ->orderBy('likes_count', $this->orden)
                    ->paginate(15);
                break;
            default:
                $publicaciones = Publication::query()
                    ->where(function ($q) {
                        $q->where('titulo', 'like', '%' . trim($this->buscar) . '%')
                            ->orWhere('contenido', 'like', '%' . trim($this->buscar) . '%');
                    })
                    ->where('user_id', auth()->user()->id)
                    ->orderBy('id', 'desc')
                    ->paginate(15);
                break;
        }
        $tags = Tag::pluck('nombre','id')->toArray();
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
