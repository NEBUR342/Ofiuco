<?php
namespace App\Http\Livewire;

use App\Models\Friend;
use Livewire\{Component, WithPagination};

class ShowSolicitudamigo extends Component {
    use WithPagination;

    public string $campo = 'creacion', $orden = 'desc', $buscar = "";

    public function updatingBuscar() {
        $this->resetPage();
    }

    public function render() {
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

    public function ordenar(string $campo) {
        $this->orden = ($this->orden == 'asc') ? 'desc' : 'asc';
        $this->campo = $campo;
    }

    public function buscarUsuario($id) {
        return redirect()->route('perfiluser.show', compact('id'));
    }

    public function aceptarsolicitud($id) {
        $amigo = Friend::where('aceptado','NO')
            ->where(function ($query) use ($id) {
                $query->where('frienduno_id', $id)
                ->orWhere('frienddos_id', $id);
            })
            ->where(function ($query) {
                $query->where('frienduno_id', auth()->user()->id)
                ->orWhere('frienddos_id', auth()->user()->id);
            })
            ->first();
        if($amigo){
            $amigo->update([
                "aceptado" => "SI"
            ]);
            $this->emit('info', "Solicitud de amistad aceptada");
        }
    }

    public function borrarsolicitud($id) {
        $amigo = Friend::where('aceptado','NO')
            ->where(function ($query) use ($id) {
                $query->where('frienduno_id', $id)
                ->orWhere('frienddos_id', $id);
            })
            ->where(function ($query) {
                $query->where('frienduno_id', auth()->user()->id)
                ->orWhere('frienddos_id', auth()->user()->id);
            })
            ->first();
        if ($amigo) {
            $amigo->delete();
            $this->emit('info', "Solicitud de amistad borrada");
        }
    }
}
