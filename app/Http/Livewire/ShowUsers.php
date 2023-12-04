<?php
namespace App\Http\Livewire;

use App\Models\Follow;
use App\Models\Friend;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ShowUsers extends Component {
    use WithPagination;

    public string $campo = 'creacion', $orden = 'desc', $buscar = "";
    public $tipousuarios;
    public $iduser;

    public function mount($tipo, $id) {
        $this->tipousuarios = $tipo;
        $this->iduser = $id;
    }
    
    public function updatingBuscar() {
        $this->resetPage();
    }

    public function render() {
        switch ($this->tipousuarios) {
            case 1:
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
                break;
            case 2:
                $usuario = User::where('id', $this->iduser)->first();
                $follows = Follow::where('aceptado', 'SI')
                    ->where('seguido_id', $usuario->id)
                    ->get();
                foreach ($follows as $follow) {
                    if ($follow->user_id != $usuario->id) {
                        $follow->update([
                            'user_id'=>$follow->seguido_id
                        ]);
                    }
                }
                $usersAceptados = $usuario->follows()
                    ->where('aceptado', 'SI')
                    ->pluck('seguidor_id');
                // Uso este metodo para evitar que me introduzcan campos indevidos desde el "inspeccionar".
                // Considero que es una forma mas segura que introducir directamente los nombre de las columnas de las tablas.
                switch ($this->campo) {
                        // Ordeno los usuarios por id.
                    case "creacion":
                        $users = User::where(function ($q) {
                            $q->where('name', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhere('email', 'like', '%' . trim($this->buscar) . '%');
                        })
                            ->whereIn('id', $usersAceptados)
                            ->orderBy("id", $this->orden)
                            ->paginate(15);
                        break;
                        // ordeno los usuarios por nombre.
                    case "nombre":
                        $users = User::where(function ($q) {
                            $q->where('name', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhere('email', 'like', '%' . trim($this->buscar) . '%');
                        })
                            ->whereIn('id', $usersAceptados)
                            ->orderBy("name", $this->orden)
                            ->paginate(15);
                        break;
                    default:
                        $users = User::where(function ($q) {
                            $q->where('name', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhere('email', 'like', '%' . trim($this->buscar) . '%');
                        })
                            ->whereIn('id', $usersAceptados)
                            ->orderBy("id", $this->orden)
                            ->paginate(15);
                        break;
                }
                break;
            case 3:
                $usuario = User::where('id', $this->iduser)->first();
                $follows = Follow::where('aceptado', 'SI')
                    ->where('seguidor_id', $usuario->id)
                    ->get();
                foreach ($follows as $follow) {
                    if ($follow->user_id == $usuario->id) {
                        $follow->update([
                            'user_id'=>$follow->seguido_id
                        ]);
                    }
                }
                switch ($this->campo) {
                        // Ordeno los usuarios por id.
                    case "creacion":
                        $users = User::where(function ($q) {
                            $q->where('name', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhere('email', 'like', '%' . trim($this->buscar) . '%');
                        })
                            ->whereHas('follows', function ($q) {
                                $q->where('seguidor_id', $this->iduser)
                                    ->where('aceptado', 'SI');
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
                            ->whereHas('follows', function ($q) {
                                $q->where('seguidor_id', $this->iduser)
                                    ->where('aceptado', 'SI');
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
                            ->whereHas('follows', function ($q) {
                                $q->where('seguidor_id', $this->iduser)
                                    ->where('aceptado', 'SI');
                            })
                            ->orderBy("id", $this->orden)
                            ->paginate(15);
                        break;
                }
                break;
            default:
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
        }
        $friends = Friend::where('aceptado', 'SI')
            ->where(function ($query) {
                $query->where('frienduno_id', auth()->user()->id)
                    ->orWhere('frienddos_id', auth()->user()->id);
            })
            ->get();
        foreach ($friends as $friend) {
            if ($friend->user_id == auth()->user()->id) {
                if ($friend->frienduno_id == auth()->user()->id) {
                    $friend->update([
                        "user_id" => $friend->frienddos_id,
                    ]);
                } else {
                    $friend->update([
                        "user_id" => $friend->frienduno_id,
                    ]);
                }
            }
        }
        $amigos = Friend::where("frienduno_id", auth()->user()->id)
            ->orwhere("frienddos_id", auth()->user()->id)
            ->get();
        return view('livewire.show-users', compact('users', 'amigos'));
    }

    public function ordenar(string $campo) {
        $this->orden = ($this->orden == 'asc') ? 'desc' : 'asc';
        $this->campo = $campo;
    }

    public function buscarUsuario($id) {
        return redirect()->route('perfiluser.show', compact('id'));
    }

    public function solicitudamigo($id) {
        // me aseguro de que no modifiquen desde la consola para repetir amigos
        $amigos = Friend::where("frienduno_id", auth()->user()->id)
            ->orwhere("frienddos_id", auth()->user()->id)
            ->get();
        if (auth()->user()->id == $id || ($amigos->contains('frienduno_id', $id) || $amigos->contains('frienddos_id', $id))) return;
        // pongo primero el usuario con id menor.
        // asi evito amigos duplicados
        if ($id > auth()->user()->id) {
            Friend::create([
                'user_id' => auth()->user()->id,
                'frienduno_id' => auth()->user()->id,
                'frienddos_id' => $id,
                'aceptado' => "NO"
            ]);
        } else {
            Friend::create([
                'user_id' => auth()->user()->id,
                'frienduno_id' => $id,
                'frienddos_id' => auth()->user()->id,
                'aceptado' => "NO"
            ]);
        }
        $this->emit('info', "Solicitud de amistad enviada");
    }

    public function borraramigo($id) {
        // me aseguro de que no modifiquen desde la consola para repetir amigos
        $amigo = Friend::where(function ($query) use ($id) {
            $query->where('frienduno_id', $id)
                ->orWhere('frienddos_id', $id);
        })
            ->where(function ($query) {
                $query->where('frienduno_id', auth()->user()->id)
                    ->orWhere('frienddos_id', auth()->user()->id);
            })
            ->first();
        if ($amigo && $amigo->aceptado == "SI") {
            $amigo->delete();
            $this->emit('info', "Amistad borrada");
        } elseif ($amigo && $amigo->aceptado == "NO") {
            $amigo->delete();
            $this->emit('info', "Solicitud de amistad borrada");
        }
    }
}
