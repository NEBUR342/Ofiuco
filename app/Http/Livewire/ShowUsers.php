<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ShowUsers extends Component
{
    use WithPagination;

    public string $campo = 'id', $orden = 'desc', $buscar = "";

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function render()
    {
        if (!auth()->user()->is_admin) abort(404);
        switch($this->campo) {
            case "creacion":
                $users = User::where(function ($q) {
                    $q->where('name', 'like', '%' . trim($this->buscar) . '%')
                        ->orWhere('email', 'like', '%' . trim($this->buscar) . '%');
                })
                    ->orderBy("id", $this->orden)
                    ->paginate(15);
                break;
            case "nombre":
                $users = User::where(function ($q) {
                    $q->where('name', 'like', '%' . trim($this->buscar) . '%')
                        ->orWhere('email', 'like', '%' . trim($this->buscar) . '%');
                })
                    ->orderBy("name", $this->orden)
                    ->paginate(15);
                break;
            default:
            $users = User::where(function ($q) {
                $q->where('name', 'like', '%' . trim($this->buscar) . '%')
                    ->orWhere('email', 'like', '%' . trim($this->buscar) . '%');
            })
                ->orderBy("id", $this->orden)
                ->paginate(15);
                break;
        }
        return view('livewire.show-users', compact('users'));
    }

    public function ordenar(string $campo)
    {
        $this->orden = ($this->orden == 'asc') ? 'desc' : 'asc';
        $this->campo = ($campo != "name" && $campo != "id") ? "id" : $campo;
    }

    public function buscarUsuario($id)
    {
        return redirect()->route('publicationsuser.show', compact('id'));
    }
}
