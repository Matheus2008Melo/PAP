<?php

namespace App\Livewire\Disciplinas;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Disciplina;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    public function delete(Disciplina $disciplina)
    {
        $disciplina->delete();
        session()->flash('success', 'Disciplina eliminada com sucesso!');
    }

    public function toggleStatus(Disciplina $disciplina)
    {
        $disciplina->update(['is_active' => !$disciplina->is_active]);
        session()->flash('success', 'Status da disciplina atualizado!');
    }

    public function render()
    {
        $disciplinas = Disciplina::when($this->search, function ($query) {
                $query->where('nome', 'like', '%' . $this->search . '%')
                      ->orWhere('abreviatura', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('is_active', $this->statusFilter === 'active');
            })
            ->orderBy('ordem')
            ->orderBy('nome')
            ->paginate(10);

        return view('livewire.disciplinas.index', [
            'disciplinas' => $disciplinas,
        ]);
    }
}