<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;

class ShowTags extends Component
{
    use WithPagination;

    public string $campo = 'creacion', $orden = 'desc', $buscar = "";
    public Tag $miTag;
    public bool $openEditar = false;
    protected $listeners = ["render"];

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    protected function rules(): array
    {
        // Compruebo los campos de la ventana modal para editar las etiquetas
        return [
            'miTag.nombre' => ['required', 'string', 'min:3', 'unique:tags,nombre,' . $this->miTag->id, 'max:255'],
            'miTag.descripcion' => ['required', 'string', 'min:3'],
            'miTag.color' => ['nullable', 'regex:/#[A-Fa-f0-9]{6}/']
        ];
    }

    public function render()
    {
        // Compruebo que el usuario autenticado sea un administrador.
        if (!auth()->user()->is_admin) abort(404);
        // Uso este metodo para evitar que me introduzcan campos indevidos desde el "inspeccionar".
        // Considero que es una forma mas segura que introducir directamente los nombre de las columnas de las tablas.
        switch ($this->campo) {
            // Ordeno las etiquetas por id.
            case "creacion":
                $tags = Tag::where(function ($q) {
                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%')
                        ->orWhere('descripcion', 'like', '%' . trim($this->buscar) . '%');
                })
                    ->orderBy("id", $this->orden)
                    ->paginate(15);
                break;
            // Ordeno las etiquetas por nombre.
            case "nombre":
                $tags = Tag::where(function ($q) {
                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%')
                        ->orWhere('descripcion', 'like', '%' . trim($this->buscar) . '%');
                })
                    ->orderBy("nombre", $this->orden)
                    ->paginate(15);
                break;
            // En el default, para evitar que de error, he puesto que me las ordene por id.
            default:
                $tags = Tag::where(function ($q) {
                    $q->where('nombre', 'like', '%' . trim($this->buscar) . '%')
                        ->orWhere('descripcion', 'like', '%' . trim($this->buscar) . '%');
                })
                    ->orderBy("id", $this->orden)
                    ->paginate(15);
                break;
        }
        return view('livewire.show-tags', compact('tags'));
    }

    public function ordenar(string $campo)
    {
        $this->orden = ($this->orden == 'asc') ? 'desc' : 'asc';
        $this->campo = ($campo != "nombre" && $campo != "id") ? "id" : $campo;
    }

    public function borrarEtiqueta($tag)
    {
        $etiqueta = Tag::where('id', $tag)->first();
        $etiqueta->delete();
        $this->emit('info', "La etiqueta se ha borrado");
    }

    public function editar(Tag $miTag)
    {
        $this->miTag = $miTag;
        $this->openEditar = true;
    }

    public function update()
    {
        // Valido los campos de la ventana modal.
        $this->validate();
        // Modifico los valores de la base da datos.
        $this->miTag->update([
            'nombre' => $this->miTag->nombre,
            'descripcion' => $this->miTag->descripcion,
            'color' => $this->miTag->color,
        ]);
        // Reseteo la variable
        $this->miTag = new Tag;
        $this->reset('openEditar');
        $this->emit('info', 'Etiqueta editada con éxito');
    }
}
