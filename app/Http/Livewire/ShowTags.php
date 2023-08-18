<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;

class ShowTags extends Component
{
    use WithPagination;

    public string $campo = 'id', $orden = 'desc', $buscar = "";
    public Tag $miTag;
    public bool $openEditar = false;
    protected $listeners = ["render"];

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function render()
    {
        $tags = Tag::where(function ($q) {
            $q->where('nombre', 'like', '%' . trim($this->buscar) . '%')
                ->orWhere('descripcion', 'like', '%' . trim($this->buscar) . '%');
        })
            ->orderBy($this->campo, $this->orden)
            ->paginate(15);
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

    protected function rules(): array
    {
        return [
            'miTag.nombre' => ['required', 'string', 'min:3', 'unique:tags,nombre,' . $this->miTag->id],
            'miTag.descripcion' => ['required', 'string', 'min:3'],
            'miTag.color' => ['nullable', 'regex:/#[A-Fa-f0-9]{6}/']
        ];
    }

    public function update()
    {
        $this->validate();
        //Actualizamos el registro
        $this->miTag->update([
            'nombre' => $this->miTag->nombre,
            'descripcion' => $this->miTag->descripcion,
            'color' => $this->miTag->color,
        ]);
        $this->miTag = new Tag;
        $this->reset('openEditar');
        $this->emit('info', 'Etiqueta editada con éxito');
    }
}
