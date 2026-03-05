<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Disciplina;
use App\Models\Projeto;

class Index extends Component
{
    public $featuredProjetos;
    public $disciplinas;
    public $recentProjetos;
    public $stats;
    public $availableAnosLetivos = [];
    public $selectedAnoLetivo = '';

    public function mount()
    {
        // Projetos em destaque
        $this->featuredProjetos = Projeto::where('status', 'aprovado')
            ->where('is_featured', true)
            ->with(['disciplina', 'user'])
            ->latest('published_at')
            ->take(6)
            ->get();

        // Todas as disciplinas ativas
        $this->disciplinas = Disciplina::where('is_active', true)
            ->orderBy('ordem')
            ->orderBy('nome')
            ->get();

        // Projetos recentes
        $this->recentProjetos = Projeto::where('status', 'aprovado')
            ->with(['disciplina', 'user'])
            ->latest('published_at')
            ->take(8)
            ->get();

        // Estatísticas
        $this->stats = [
            'projetos' => Projeto::where('status', 'aprovado')->count(),
            'disciplinas' => Disciplina::where('is_active', true)->count(),
            'autores' => \App\Models\User::has('projetos')->count(),
        ];

        // Anos letivos disponíveis para o filtro
        $this->availableAnosLetivos = Projeto::where('status', 'aprovado')
            ->select('ano_letivo')
            ->distinct()
            ->orderBy('ano_letivo', 'desc')
            ->pluck('ano_letivo');
    }

    public function updatedSelectedAnoLetivo()
    {
        // Se um ano for selecionado, recarrega os dados filtrando por ele
        if ($this->selectedAnoLetivo) {
            $this->disciplinas = Disciplina::where('is_active', true)
                ->whereHas('projetos', function ($q) {
                    $q->where('status', 'aprovado')
                      ->where('ano_letivo', $this->selectedAnoLetivo);
                })
                ->orderBy('ordem')
                ->orderBy('nome')
                ->get();
        } else {
            // Se "Todos os anos" for selecionado, recarrega a vista base
            $this->disciplinas = Disciplina::where('is_active', true)
                ->orderBy('ordem')
                ->orderBy('nome')
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.home.index', [
            'availableAnosLetivos' => $this->availableAnosLetivos
        ]);
    }
}