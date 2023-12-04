<?php
namespace App\Http\Livewire;

use App\Models\Community;
use Livewire\{Component, WithPagination};

class ShowCommunities extends Component {
    use WithPagination;

    public int $tipoConsulta = 1;
    public string $campo = 'id', $orden = 'desc', $buscar = "";
    public $imagen;

    public function updatingBuscar() {
        $this->resetPage();
    }

    public function render() {
        $user = auth()->user();
        // Uso este metodo para evitar que me introduzcan campos indevidos desde el "inspeccionar".
        // Considero que es una forma mas segura que introducir directamente los nombre de las columnas de las tablas.
        switch ($this->tipoConsulta) {
            case 1:
                // Uso este metodo para evitar que me introduzcan campos indevidos desde el "inspeccionar".
                // Considero que es una forma mas segura que introducir directamente los nombre de las columnas de las tablas.
                switch ($this->campo) {
                    case "creacion":
                        // Busco lo introducido en el "buscador" en la vista.
                        // Si no hay nada, me saca todas las comunidades.
                        // Las muestro ordenadas por id.
                        $comunidades = Community::where(function ($q) {
                            $q->where('nombre', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhere('descripcion', 'like', '%' . trim($this->buscar) . '%');
                        })
                            ->orderBy("id", $this->orden)
                            ->paginate(15);
                        break;
                    case "nombre":
                        // Busco lo introducido en el "buscador" en la vista.
                        // Si no hay nada, me saca todas las comunidades.
                        // Las muestro ordenadas por nombre.
                        $comunidades = Community::where(function ($q) {
                            $q->where('nombre', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhere('descripcion', 'like', '%' . trim($this->buscar) . '%');
                        })
                            ->orderBy("nombre", $this->orden)
                            ->paginate(15);
                        break;
                    default:
                        // Busco lo introducido en el "buscador" en la vista.
                        // Si no hay nada, me saca todas las comunidades.
                        // Las muestro ordenadas por id, ya que no se ha encontrado otro.
                        $comunidades = Community::where(function ($q) {
                            $q->where('nombre', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhere('descripcion', 'like', '%' . trim($this->buscar) . '%');
                        })
                            ->orderBy("id", $this->orden)
                            ->paginate(15);
                        break;
                }
                break;
            case 2:
                // Uso este metodo para evitar que me introduzcan campos indevidos desde el "inspeccionar".
                // Considero que es una forma mas segura que introducir directamente los nombre de las columnas de las tablas.
                switch ($this->campo) {
                    case "creacion":
                        $comunidades = Community::where('user_id', $user->id)
                            ->where(function ($q) {
                                $q->where('nombre', 'like', '%' . trim($this->buscar) . '%')
                                    ->orWhere('descripcion', 'like', '%' . trim($this->buscar) . '%');
                            })
                            ->orderBy("id", $this->orden)
                            ->paginate(15);
                    case "nombre":
                        $comunidades = Community::where('user_id', $user->id)
                            ->where(function ($q) {
                                $q->where('nombre', 'like', '%' . trim($this->buscar) . '%')
                                    ->orWhere('descripcion', 'like', '%' . trim($this->buscar) . '%');
                            })
                            ->orderBy("nombre", $this->orden)
                            ->paginate(15);
                        break;
                    default:
                        $comunidades = Community::where('user_id', $user->id)
                            ->where(function ($q) {
                                $q->where('nombre', 'like', '%' . trim($this->buscar) . '%')
                                    ->orWhere('descripcion', 'like', '%' . trim($this->buscar) . '%');
                            })
                            ->orderBy("id", $this->orden)
                            ->paginate(15);
                        break;
                }
                break;
            case 3:
                // Uso este metodo para evitar que me introduzcan campos indevidos desde el "inspeccionar".
                // Considero que es una forma mas segura que introducir directamente los nombre de las columnas de las tablas.
                switch ($this->campo) {
                    case "creacion":
                        $comunidades = Community::where(function ($q) {
                            $q->where('nombre', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhere('descripcion', 'like', '%' . trim($this->buscar) . '%');
                        })
                            ->whereHas('users', function ($query) use ($user) {
                                $query->where('user_id', $user->id);
                            })
                            ->orderBy("id", $this->orden)
                            ->paginate(15);
                        break;
                    case "nombre":
                        $comunidades = Community::where(function ($q) {
                            $q->where('nombre', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhere('descripcion', 'like', '%' . trim($this->buscar) . '%');
                        })
                            ->whereHas('users', function ($query) use ($user) {
                                $query->where('user_id', $user->id);
                            })
                            ->orderBy("nombre", $this->orden)
                            ->paginate(15);
                        break;
                    default:
                    $comunidades = Community::where(function ($q) {
                        $q->where('nombre', 'like', '%' . trim($this->buscar) . '%')
                            ->orWhere('descripcion', 'like', '%' . trim($this->buscar) . '%');
                    })
                        ->whereHas('users', function ($query) use ($user) {
                            $query->where('user_id', $user->id);
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
                    case "creacion":
                        // Busco lo introducido en el "buscador" en la vista.
                        // Si no hay nada, me saca todas las comunidades.
                        // Las muestro ordenadas por id.
                        $comunidades = Community::where(function ($q) {
                            $q->where('nombre', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhere('descripcion', 'like', '%' . trim($this->buscar) . '%');
                        })
                            ->orderBy("id", $this->orden)
                            ->paginate(15);
                        break;
                    case "nombre":
                        // Busco lo introducido en el "buscador" en la vista.
                        // Si no hay nada, me saca todas las comunidades.
                        // Las muestro ordenadas por nombre.
                        $comunidades = Community::where(function ($q) {
                            $q->where('nombre', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhere('descripcion', 'like', '%' . trim($this->buscar) . '%');
                        })
                            ->orderBy("nombre", $this->orden)
                            ->paginate(15);
                        break;
                    default:
                        // Busco lo introducido en el "buscador" en la vista.
                        // Si no hay nada, me saca todas las comunidades.
                        // Las muestro ordenadas por id, ya que no se ha encontrado otro.
                        $comunidades = Community::where(function ($q) {
                            $q->where('nombre', 'like', '%' . trim($this->buscar) . '%')
                                ->orWhere('descripcion', 'like', '%' . trim($this->buscar) . '%');
                        })
                            ->orderBy("id", $this->orden)
                            ->paginate(15);
                        break;
                }
        }
        return view('livewire.show-communities', compact('comunidades'));
    }

    public function ordenar(string $campo) {
        $this->orden = ($this->orden == 'asc') ? 'desc' : 'asc';
        $this->campo = ($campo != "nombre" && $campo != "id") ? "id" : $campo;
    }

    public function diferenciar(string $tipo) {
        $this->tipoConsulta = $tipo;
    }

    public function verComunidad($id) {
        return redirect()->route('community.show', compact('id'));
    }
}
