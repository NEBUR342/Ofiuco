<?php

namespace App\Http\Livewire;

use App\Models\Community;
use App\Models\Publication;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowCommunity extends Component
{
    use WithFileUploads;

    public Community $comunidad, $miComunidad;
    public bool $openEditar = false;
    public $imagen;

    public function mount($id)
    {
        $this->comunidad = Community::findOrFail($id);
    }

    protected function rules(): array
    {
        return [
            'miComunidad.nombre' => "",
            'miComunidad.descripcion' => ['required', 'string', 'min:10'],
            'miComunidad.imagen' => ['required', 'image', 'max:2048'],
        ];
    }

    public function render()
    {
        $comunidad = Community::where('id', $this->comunidad->id)->first();
        $this->comunidad = $comunidad;
        $creador = User::where('id', $comunidad->user_id)->first();
        $community_id = $comunidad->id;
        $user_id = auth()->user()->id;
        $participantes = User::whereHas('communities', function ($query) use ($community_id) {
            $query->where('community_id', $community_id);
        })->orderBy('id', 'asc')->get();
        // Compruebo que el usuario autenticado pertenece o no a la comunidad
        $aux = User::whereHas('communities', function ($query) use ($community_id) {
            $query->where('communities.id', $community_id);
        })->where('id', $user_id)->exists();
        return view('livewire.show-community', compact('comunidad', 'creador', 'participantes', 'aux'));
    }

    public function borrarComunidad()
    {
        self::comprobarPermisosComunidad($this->comunidad);
        $usuarios = $this->comunidad->users;
        foreach ($usuarios as $usuario) {
            self::quitarParticipante($usuario);
        }
        Storage::delete($this->comunidad->imagen);
        $this->comunidad->delete();
        return redirect()->route('communities.show');
    }

    public function sacarParticipante(User $participante)
    {
        self::quitarParticipante($participante);
        $this->emit('info', "Participante " . $participante->name . " ha salido");
    }

    private function quitarParticipante(User $participante)
    {
        $userId = $participante->id;
        $communityId = $this->comunidad->id;
        $publicaciones = Publication::whereHas('community', function ($query) use ($communityId) {
            $query->where('id', $communityId);
        })->where('user_id', $userId)->get();
        foreach ($publicaciones as $publicacion) {
            Storage::delete($publicacion->imagen);
            $publicacion->delete();
        }
        $participante->communities()->detach($this->comunidad->id);
    }

    public function meterParticipante()
    {
        $user = auth()->user();
        // Da error en codigo, pero lo hace bien.
        $user->communities()->attach($this->comunidad);
        $this->emit('info', "Participante " . $user->name . " ha entrado");
    }

    public function editar(Community $comunidad)
    {
        self::comprobarPermisosComunidad($comunidad);
        $this->miComunidad = $comunidad;
        $this->openEditar = true;
    }

    public function update()
    {
        $this->validate([
            'miComunidad.nombre' => ['required', 'string', 'min:3', 'unique:communities,nombre,' . $this->comunidad->id]
        ]);
        if ($this->imagen) {
            Storage::delete($this->comunidad->imagen);
            $this->comunidad->imagen = $this->imagen->store('imagenesComunidad');
        }
        $this->miComunidad->update([
                "nombre" => $this->miComunidad->nombre,
                "descripcion" => $this->miComunidad->descripcion,
                "imagen" => $this->comunidad->imagen,
            ]);
        
        $this->miComunidad = new Community();
        // Para borrar la carpeta livewire-tmp que me genera livewire, pero no la borra, he usado la siguiente solucion
        $this->reset('openEditar');
        $this->emit('info', 'Comunidad editada con éxito');
        File::deleteDirectory(storage_path('livewire-tmp'));
    }

    public function comprobarPermisosComunidad(Community $comunidad){
        if(auth()->user()->is_admin) return;
        if($comunidad->user_id == auth()->user()->id) return;
        abort(404);
    }
}
