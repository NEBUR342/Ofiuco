<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Publication;
use App\Models\Save;
use Livewire\Component;

class ShowNotificaciones extends Component
{
    public $tiponotificacion;
    public function mount($id)
    {
        $this->tiponotificacion = $id;
    }
    public function render()
    {
        
        $publicacionesIds = Publication::where('user_id',auth()->user()->id)->pluck('id'); 
       
        switch ($this->tiponotificacion) {
            case 1: // Likes
                $mensaje = "Le ha dado like a la publicacion: ";
                $notificaciones = Like::whereIn('publication_id', $publicacionesIds)
                ->orderBy('id', 'desc')
                ->paginate(15);
                break;
            case 2: // Guardados
                $mensaje = "Se ha guardado la publicacion: ";
                $notificaciones = Save::whereIn('publication_id', $publicacionesIds)
                ->orderBy('id', 'desc')
                ->paginate(15);
                break;
            case 3: // comentarios
                $mensaje = "Ha comentado en la publicacion: ";
                $notificaciones = Comment::whereIn('publication_id', $publicacionesIds)
                ->orderBy('id', 'desc')
                ->paginate(15);
                break;
            default:
                abort(404);
        }
        return view('livewire.show-notificaciones', compact("notificaciones", "mensaje"));
    }
    public function buscarUsuario($id)
    {
        return redirect()->route('perfiluser.show', compact('id'));
    }
    public function verPublicacion($id)
    {
        return redirect()->route('publication.show', compact('id'));
    }
}
