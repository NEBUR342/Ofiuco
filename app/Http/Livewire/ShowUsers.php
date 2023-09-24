<?php

namespace App\Http\Livewire;

use App\Models\Friend;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ShowUsers extends Component
{
    use WithPagination;

    public string $campo = 'creacion', $orden = 'desc', $buscar = "";

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Uso este metodo para evitar que me introduzcan campos indevidos desde el "inspeccionar".
        // Considero que es una forma mas segura que introducir directamente los nombre de las columnas de las tablas.
        switch ($this->campo) {
                // Ordeno los usuarios por id.
            case "creacion":
                $users = User::where(function ($q) {
                    $q->where('name', 'like', '%' . trim($this->buscar) . '%')
                        ->orWhere('email', 'like', '%' . trim($this->buscar) . '%');
                })
                    ->orderBy("id", $this->orden)
                    ->paginate(15);
                break;
                // ordeno los usuarios por nombre.
            case "nombre":
                $users = User::where(function ($q) {
                    $q->where('name', 'like', '%' . trim($this->buscar) . '%')
                        ->orWhere('email', 'like', '%' . trim($this->buscar) . '%');
                })
                    ->orderBy("name", $this->orden)
                    ->paginate(15);
                break;
                // En el default, para evitar que de error, he puesto que me los ordene por id.
            default:
                $users = User::where(function ($q) {
                    $q->where('name', 'like', '%' . trim($this->buscar) . '%')
                        ->orWhere('email', 'like', '%' . trim($this->buscar) . '%');
                })
                    ->orderBy("id", $this->orden)
                    ->paginate(15);
                break;
        }
        $amigos=Friend::where("frienduno_id",auth()->user()->id)
        ->orwhere("frienddos_id",auth()->user()->id)
        ->get();
        return view('livewire.show-users', compact('users', 'amigos'));
    }

    public function ordenar(string $campo)
    {
        $this->orden = ($this->orden == 'asc') ? 'desc' : 'asc';
        $this->campo = $campo;
    }

    public function buscarUsuario($id)
    {
        return redirect()->route('publicationsuser.show', compact('id'));
    }

    public function buscarLikesUsuario($id)
    {
        return redirect()->route('publicationslikes.show', compact('id'));
    }
    public function buscarSavesUsuario($id)
    {
        // Compruebo que el usuario autenticado sea un administrador.
        if (!auth()->user()->is_admin) abort(404);
        return redirect()->route('publicationssaves.show', compact('id'));
    }

    public function solicitudamigo($id)
    {
        // me aseguro de que no modifiquen desde la consola para repetir amigos
        $amigos=Friend::where("frienduno_id",auth()->user()->id)
        ->orwhere("frienddos_id",auth()->user()->id)
        ->get();
        if(auth()->user()->id == $id || ($amigos->contains('frienduno_id', $id) || $amigos->contains('frienddos_id', $id)))return;
        // pongo primero el usuario con id menor.
        // asi evito amigos duplicados
        if ($id > auth()->user()->id) {
            Friend::create([
                'user_id' => auth()->user()->id,
                'frienduno_id' => auth()->user()->id,
                'frienddos_id' => $id,
                'aceptado'=>"NO"
            ]);
        }else{
            Friend::create([
                'user_id' => auth()->user()->id,
                'frienduno_id' => $id,
                'frienddos_id' => auth()->user()->id,
                'aceptado'=>"NO"
            ]);
        }
        $this->emit('info', "Solicitud de amistad enviada");
    }

    public function borraramigo($id)
    {
        // me aseguro de que no modifiquen desde la consola para repetir amigos
        $amigo=Friend::where(function ($query) use ($id) {
            $query->where('frienduno_id', $id)
                ->orWhere('frienddos_id', $id);
        })
        ->where(function ($query) {
            $query->where('frienduno_id', auth()->user()->id)
                ->orWhere('frienddos_id', auth()->user()->id);
        })
        ->first();
        if($amigo && $amigo->aceptado=="SI"){
            $amigo->delete();
            $this->emit('info', "Amistad borrada");
        }elseif($amigo && $amigo->aceptado=="NO"){
            $amigo->delete();
            $this->emit('info', "Solicitud de amistad borrada");
        }
    }
}
