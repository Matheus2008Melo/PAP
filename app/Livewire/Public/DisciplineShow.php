<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Disciplina;
use App\Models\Projeto;
use App\Models\Tag;

class DisciplineShow extends Component
{
    use \Livewire\WithPagination;

    public $disciplina;
    public $selectedAnoLetivo = '';
    public $selectedTag = '';
    public $sortBy = 'newest';
    
    public $availableAnosLetivos = [];
    public $availableTags = [];

    public function mount($slug)
    {
        $this->disciplina = Disciplina::where('slug', $slug)->firstOrFail();
        $this->loadFilters();
    }

    public function loadFilters()
    {
        // Carregar anos disponíveis para esta disciplina (como principal ou secundária)
        $this->availableAnosLetivos = Projeto::where('status', 'aprovado')
            ->where(function($query) {
                $query->where('disciplina_id', $this->disciplina->id)
                      ->orWhereHas('disciplinasSecundarias', function($q) {
                          $q->where('disciplinas.id', $this->disciplina->id);
                      });
            })
            ->select('ano_letivo')
            ->distinct()
            ->orderBy('ano_letivo', 'desc')
            ->pluck('ano_letivo');

        // Carregar tags disponíveis para esta disciplina
        $this->availableTags = Tag::whereHas('projetos', function ($query) {
            $query->where('status', 'aprovado')
                  ->where(function($q) {
                      $q->where('disciplina_id', $this->disciplina->id)
                        ->orWhereHas('disciplinasSecundarias', function($q2) {
                            $q2->where('disciplinas.id', $this->disciplina->id);
                        });
                  });
        })->get();
    }

    public function updatingSelectedAnoLetivo()
    {
        $this->resetPage();
    }

    public function updatingSelectedTag()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Projeto::where('status', 'aprovado')
            ->where(function($q) {
                $q->where('disciplina_id', $this->disciplina->id)
                  ->orWhereHas('disciplinasSecundarias', function($q2) {
                      $q2->where('disciplinas.id', $this->disciplina->id);
                  });
            })
            ->with(['user', 'tags', 'disciplina']);

        // Aplicar filtro de ano
        if ($this->selectedAnoLetivo) {
            $query->where('ano_letivo', $this->selectedAnoLetivo);
        }

        // Aplicar filtro de tag
        if ($this->selectedTag) {
            $query->whereHas('tags', function ($q) {
                $q->where('slug', $this->selectedTag);
            });
        }

        // Aplicar ordenação
        switch ($this->sortBy) {
            case 'newest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'popular':
                // Aqui poderia ser por votos ou visualizações
                $query->latest();
                break;
        }

        $projetos = $query->paginate(12);

        return view('livewire.public.discipline-show', [
            'disciplina' => $this->disciplina,
            'projetos' => $projetos,
            'availableAnosLetivos' => $this->availableAnosLetivos,
            'availableTags' => $this->availableTags,
        ]);
    }
}
