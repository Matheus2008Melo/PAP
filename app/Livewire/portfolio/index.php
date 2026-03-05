<?php

namespace App\Livewire\Portfolio;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Projeto;
use App\Models\Disciplina;
use App\Models\Tag;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $disciplinaFilter = '';
    public $tagFilter = '';
    public $sortBy = 'recent';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDisciplinaFilter()
    {
        $this->resetPage();
    }

    public function updatingTagFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $projetos = Projeto::where('status', 'aprovado')
            ->with(['disciplina', 'user', 'tags'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('titulo', 'like', '%' . $this->search . '%')
                      ->orWhere('descricao', 'like', '%' . $this->search . '%')
                      ->orWhere('descricao_curta', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->disciplinaFilter, function ($query) {
                $query->where('disciplina_id', $this->disciplinaFilter);
            })
            ->when($this->tagFilter, function ($query) {
                $query->whereHas('tags', function ($q) {
                    $q->where('tags.id', $this->tagFilter);
                });
            })
            ->when($this->sortBy === 'recent', function ($query) {
                $query->latest('published_at');
            })
            ->when($this->sortBy === 'popular', function ($query) {
                $query->orderBy('vote_score', 'desc')
                      ->orderBy('visitas', 'desc');
            })
            ->when($this->sortBy === 'oldest', function ($query) {
                $query->oldest('published_at');
            })
            ->paginate(12);

        return view('livewire.portfolio.index', [
            'projetos' => $projetos,
            'disciplinas' => Disciplina::where('is_active', true)->get(),
            'tags' => Tag::where('tipo', 'ano_escolar')->get(),
        ]);
    }
}