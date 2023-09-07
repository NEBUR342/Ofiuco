<?php

namespace App\Http\Livewire;

use App\Models\Community;
use App\Models\Request;
use App\Models\User;
use Livewire\Component;

class ShowSolicitudparticipante extends Component
{
    public function render()
    {
        $solicitudes=Request::whereIn('community_id', Community::where('user_id', auth()->user()->id)->pluck('id'))->paginate(15);
        return view('livewire.show-solicitudparticipante', compact('solicitudes'));
    }

    public function verComunidad($id)
    {
        return redirect()->route('community.show', compact('id'));
    }

    public function buscarUsuario($id)
    {
        return redirect()->route('publicationsuser.show', compact('id'));
    }

    public function aceptarUsuario(Request $solicitud){
        self::comprobarUsuarios($solicitud->user, $solicitud->community);
        $solicitud->user->communities()->attach($solicitud->community);
        $solicitud->delete();
        $this->emit('info', "Participante " . $solicitud->user->name . " ha entrado");
    }

    public function rechazarUsuario(Request $solicitud){
        self::comprobarUsuarios($solicitud->user, $solicitud->community);
        $solicitud->delete();
        $this->emit('info', "Participante " . $solicitud->user->name . " no ha entrado");
    }

    private function comprobarUsuarios(User $user, Community $community){
        $solicitudes=Request::whereIn('community_id', Community::where('user_id', auth()->user()->id)->pluck('id'))->get();
        foreach($solicitudes as $solicitud){
            if($solicitud->user_id == $user->id && $solicitud->community_id==$community->id){
                return;
            }
        }
        abort(404);
    }
}
