<?php

namespace App\Http\Livewire;

use App\Models\Community;
use App\Models\Request;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ShowSolicitudparticipante extends Component
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
                $solicitudes = Request::whereIn('community_id', Community::where('user_id', auth()->user()->id)
                    ->orderBy('id')->pluck('id'))
                    ->whereHas('user', function ($query) {
                        $query->where('name', 'LIKE', '%' . $this->buscar . '%')
                            ->orWhere('email', 'LIKE', '%' . $this->buscar . '%');
                    })
                    ->paginate(15);
                break;
            case "nombre":
                $solicitudes = Request::whereIn('community_id', Community::where('user_id', auth()->user()->id)
                    ->orderBy('nombre')->pluck('id'))
                    ->whereHas('user', function ($query) {
                        $query->where('name', 'LIKE', '%' . $this->buscar . '%')
                            ->orWhere('email', 'LIKE', '%' . $this->buscar . '%');
                    })
                    ->paginate(15);
                break;
            default:
                $solicitudes = Request::whereIn('community_id', Community::where('user_id', auth()->user()->id)
                    ->orderBy('id')->pluck('id'))
                    ->whereHas('user', function ($query) {
                        $query->where('name', 'LIKE', '%' . $this->buscar . '%')
                            ->orWhere('email', 'LIKE', '%' . $this->buscar . '%');
                    })
                    ->paginate(15);
        }
        return view('livewire.show-solicitudparticipante', compact('solicitudes'));
    }
    public function ordenar(string $campo)
    {
        $this->orden = ($this->orden == 'asc') ? 'desc' : 'asc';
        $this->campo = $campo;
    }
    public function verComunidad($id)
    {
        return redirect()->route('community.show', compact('id'));
    }

    public function buscarUsuario($id)
    {
        return redirect()->route('publicationsuser.show', compact('id'));
    }

    public function aceptarUsuario(Request $solicitud)
    {
        self::comprobarUsuarios($solicitud->user, $solicitud->community);
        $solicitud->user->communities()->attach($solicitud->community);
        $solicitud->delete();
        $this->emit('info', "Participante " . $solicitud->user->name . " ha entrado");
    }

    public function rechazarUsuario(Request $solicitud)
    {
        self::comprobarUsuarios($solicitud->user, $solicitud->community);
        $solicitud->delete();
        $this->emit('info', "Participante " . $solicitud->user->name . " no ha entrado");
    }

    private function comprobarUsuarios(User $user, Community $community)
    {
        $solicitudes = Request::whereIn('community_id', Community::where('user_id', auth()->user()->id)->pluck('id'))->get();
        foreach ($solicitudes as $solicitud) {
            if ($solicitud->user_id == $user->id && $solicitud->community_id == $community->id) {
                return;
            }
        }
        abort(404);
    }
}
