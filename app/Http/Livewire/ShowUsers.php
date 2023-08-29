<?php

namespace App\Http\Livewire;

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
        // Compruebo que el usuario autenticado sea un administrador.
        if (!auth()->user()->is_admin) abort(404);
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
        return view('livewire.show-users', compact('users'));
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
}
