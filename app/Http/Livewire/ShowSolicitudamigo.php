<?php

namespace App\Http\Livewire;

use App\Models\Friend;
use Livewire\Component;
use Livewire\WithPagination;

class ShowSolicitudamigo extends Component
{
    use WithPagination;

    public string $campo = 'creacion', $orden = 'desc', $buscar = "";

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function render()
    {
        switch ($this->campo) {
            case "creacion":
                $solicitudes = Friend::where('aceptado', 'NO')
                    ->where(function ($query) {
                        $query->where('frienduno_id', auth()->user()->id)
                            ->orWhere('frienddos_id', auth()->user()->id);
                    })
                    ->where('user_id', '!=', auth()->user()->id)
                    ->whereHas('user', function ($query) {
                        $query->where('name', 'LIKE', '%' . $this->buscar . '%')
                            ->orWhere('email', 'LIKE', '%' . $this->buscar . '%');
                    })
                    ->orderBy("id", $this->orden)
                    ->paginate(15);
                break;
            case "nombre":
                $solicitudes = Friend::leftJoin('users', 'friends.user_id', '=', 'users.id')
                    ->where('aceptado', 'NO')
                    ->where(function ($query) {
                        $query->where('frienduno_id', auth()->user()->id)
                            ->orWhere('frienddos_id', auth()->user()->id);
                    })
                    ->where('user_id', '!=', auth()->user()->id)
                    ->whereHas('user', function ($query) {
                        $query->where('name', 'LIKE', '%' . $this->buscar . '%')
                            ->orWhere('email', 'LIKE', '%' . $this->buscar . '%');
                    })
                    ->orderBy("users.name", $this->orden)
                    ->paginate(15);
                break;
            default:
                $solicitudes = Friend::where('aceptado', 'NO')
                    ->where(function ($query) {
                        $query->where('frienduno_id', auth()->user()->id)
                            ->orWhere('frienddos_id', auth()->user()->id);
                    })
                    ->where('user_id', '!=', auth()->user()->id)
                    ->whereHas('user', function ($query) {
                        $query->where('name', 'LIKE', '%' . $this->buscar . '%')
                            ->orWhere('email', 'LIKE', '%' . $this->buscar . '%');
                    })
                    ->orderBy("id", $this->orden)
                    ->paginate(15);
                break;
        }
        return view('livewire.show-solicitudamigo', compact('solicitudes'));
    }

    public function ordenar(string $campo)
    {
        $this->orden = ($this->orden == 'asc') ? 'desc' : 'asc';
        $this->campo = $campo;
    }

    public function buscarUsuario($id)
    {
        return redirect()->route('perfiluser.show', compact('id'));
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
        $amigos = Friend::where("id", $id)->first();
        $amigos->update([
            "aceptado" => "SI"
        ]);
        $this->emit('info', "Solicitud de amistad aceptada");
    }

    public function borrarsolicitudamigo($id)
    {
        // me aseguro de que no modifiquen desde la consola para repetir amigos
        $amigos = Friend::where(function ($query) use ($id) {
            $query->where('frienduno_id', $id)
                ->orWhere('frienddos_id', $id);
        })
            ->where(function ($query) {
                $query->where('frienduno_id', auth()->user()->id)
                    ->orWhere('frienddos_id', auth()->user()->id);
            })
            ->first();
        if ($amigos) {
            $amigos->delete();
            $this->emit('info', "Solicitud de amistad borrada");
        }
    }
}
