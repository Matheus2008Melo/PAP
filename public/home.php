<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Disciplina;
use App\Models\Projeto;
use App\Models\User;
use App\Models\Comment;

class Home extends Component
{
    public $search = '';
    public $selectedYear;

    public function mount()
    {
        $this->selectedYear = date('Y');
    }

    public function render()
    {
        // Obter disciplinas com contagem de projetos
        $disciplinas = Disciplina::active()
            ->withCount(['projetos' => function ($query) {
                $query->where('status', 'aprovado');
                if ($this->selectedYear) {
                    $query->where('year', $this->selectedYear);
                }
            }])
            ->ordered()
            ->get();

        // Obter anos disponíveis de projetos aprovados
        $availableYears = Projeto::where('status', 'aprovado')
            ->select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Estatísticas para exibir
        $stats = [
            'totalProjects' => Projeto::where('status', 'aprovado')->count(),
            'totalUsers' => User::count(),
            'totalDisciplines' => Disciplina::active()->count(),
            'totalComments' => Comment::count(),
        ];

        return view('livewire.public.home', [
            'disciplinas' => $disciplinas,
            'availableYears' => $availableYears,
            'stats' => $stats,
        ]);
    }
}