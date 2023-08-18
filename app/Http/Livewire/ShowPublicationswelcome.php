<?php

namespace App\Http\Livewire;

use App\Models\Publication;
use Livewire\Component;

class ShowPublicationswelcome extends Component
{

    public function render()
    {
        $publicaciones = Publication::where('estado', 'PUBLICADO')
            ->where('comunidad', 'NO')
            ->orderBy('id', 'desc')
            ->paginate(15);
        return view('livewire.show-publicationswelcome', compact('publicaciones'));
    }

    public function verPublicacion($id){
        return redirect()->route('publication.show', compact('id'));
    }
}
