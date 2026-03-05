<?php

namespace App\Livewire\Projetos;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Projeto;
use App\Models\Disciplina;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $disciplinaFilter = '';
    public $statusFilter = '';

    public function delete(Projeto $projeto)
    {
        $projeto->delete();
        session()->flash('success', 'Projeto eliminado com sucesso!');
    }

    public function approve(Projeto $projeto)
    {
        $projeto->update([
            'status' => 'aprovado',
            'published_at' => now(),
        ]);
        session()->flash('success', 'Projeto aprovado com sucesso!');
    }

    public function render()
    {
        $projetos = Projeto::with(['disciplina', 'user', 'tags'])
            ->when($this->search, function ($query) {
                $query->where('titulo', 'like', '%' . $this->search . '%')
                      ->orWhere('descricao', 'like', '%' . $this->search . '%');
            })
            ->when($this->disciplinaFilter, function ($query) {
                $query->where('disciplina_id', $this->disciplinaFilter);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.projetos.index', [
            'projetos' => $projetos,
            'disciplinas' => Disciplina::where('is_active', true)->get(),
        ]);
    }
}