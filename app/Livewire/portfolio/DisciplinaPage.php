<?php

namespace App\Livewire\Portfolio;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Disciplina as DisciplinaModel;

class DisciplinaPage extends Component
{
    use WithPagination;

    public DisciplinaModel $disciplina;
    public $tagFilter = '';

    public function mount($disciplina)
    {
        $this->disciplina = DisciplinaModel::where('slug', $disciplina)->firstOrFail();
    }

    public function render()
    {
        $projetos = $this->disciplina->projetos()
            ->where('status', 'aprovado')
            ->with(['user', 'tags'])
            ->when($this->tagFilter, function ($query) {
                $query->whereHas('tags', function ($q) {
                    $q->where('tags.id', $this->tagFilter);
                });
            })
            ->latest('published_at')
            ->paginate(9);

        return view('livewire.portfolio.disciplina-page', [
            'projetos' => $projetos,
            'tags' => \App\Models\Tag::where('tipo', 'ano_escolar')->get(),
        ]);
    }
}