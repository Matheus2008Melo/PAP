<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Projeto;
use App\Models\User;
use App\Models\Disciplina;
use App\Notifications\ProjectStatusChanged;

class Dashboard extends Component
{
    public function getStatsProperty()
    {
        return [
            'total_users' => User::count(),
            'total_projects' => Projeto::count(),
            'pending_projects' => Projeto::where('status', 'pendente')->count(),
            'total_disciplines' => Disciplina::count(),
        ];
    }

    public function getPendingProjectsProperty()
    {
        return Projeto::where('status', 'pendente')
            ->with(['user', 'disciplina'])
            ->latest()
            ->get();
    }

    public function approve($id)
    {
        $projeto = Projeto::findOrFail($id);
        $projeto->update(['status' => 'aprovado']);
        
        $projeto->user->notify(new ProjectStatusChanged($projeto, 'aprovado'));
        
        session()->flash('message', "Projeto '{$projeto->titulo}' aprovado com sucesso!");
    }

    public function reject($id)
    {
        $projeto = Projeto::findOrFail($id);
        $projeto->update(['status' => 'rejeitado']);
        
        $projeto->user->notify(new ProjectStatusChanged($projeto, 'rejeitado'));
        
        session()->flash('message', "Projeto '{$projeto->titulo}' rejeitado.");
    }

    public function render()
    {
        return view('livewire.admin.dashboard')->layout('layouts.app');
    }
}
