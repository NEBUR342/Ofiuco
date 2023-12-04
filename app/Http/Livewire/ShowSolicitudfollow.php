<?php

namespace App\Http\Livewire;

use App\Models\Follow;
use Livewire\Component;
use Livewire\WithPagination;

class ShowSolicitudfollow extends Component {
    use WithPagination;
    public string $campo = 'creacion', $orden = 'desc', $buscar = "";
    public function updatingBuscar() {
        $this->resetPage();
    }
    
    public function render() {
        $follows = Follow::where('aceptado', 'NO')
            ->where('seguido_id', auth()->user()->id)
            ->get();
        foreach ($follows as $follow) {
            if ($follow->user_id == auth()->user()->id) {
                $follow->update([
                    'user_id' => $follow->seguidor_id
                ]);
            }
        }
        switch ($this->campo) {
            case "creacion":
                $solicitudes = Follow::where('aceptado', 'NO')
                    ->where('seguido_id', auth()->user()->id)
                    ->whereHas('user', function ($query) {
                        $query->where('name', 'LIKE', '%' . $this->buscar . '%')
                            ->orWhere('email', 'LIKE', '%' . $this->buscar . '%');
                    })
                    ->orderBy("id", $this->orden)
                    ->paginate(15);
                break;
            case "nombre":
                $solicitudes = Follow::leftJoin('users', 'follows.user_id', '=', 'users.id')
                    ->where('aceptado', 'NO')
                    ->where('seguido_id', auth()->user()->id)
                    ->whereHas('user', function ($query) {
                        $query->where('name', 'LIKE', '%' . $this->buscar . '%')
                            ->orWhere('email', 'LIKE', '%' . $this->buscar . '%');
                    })
                    ->orderBy("users.name", $this->orden)
                    ->paginate(15);
                break;
            default:
                $solicitudes = Follow::where('aceptado', 'NO')
                ->where('seguido_id', auth()->user()->id)
                ->whereHas('user', function ($query) {
                    $query->where('name', 'LIKE', '%' . $this->buscar . '%')
                        ->orWhere('email', 'LIKE', '%' . $this->buscar . '%');
                })
                ->orderBy("id", $this->orden)
                ->paginate(15);
                break;
        }
        return view('livewire.show-solicitudfollow', compact('solicitudes'));
    }

    public function ordenar(string $campo) {
        $this->orden = ($this->orden == 'asc') ? 'desc' : 'asc';
        $this->campo = $campo;
    }

    public function buscarUsuario($id) {
        return redirect()->route('perfiluser.show', compact('id'));
    }

    public function aceptarsolicitud($id) {
        $follow = Follow::where("id", $id)->first();
        if($follow->seguido_id == auth()->user()->id) {
            $follow->update([
                "aceptado" => "SI"
            ]);
            $this->emit('info', "Solicitud de seguimiento aceptada");
        }
    }

    public function borrarsolicitud($id) {
        $follows = Follow::where('id', $id)
            ->where('seguido_id', auth()->user()->id)
            ->first();
        if ($follows) {
            $follows->delete();
            $this->emit('info', "Solicitud de seguimiento borrada");
        }
    }
}
