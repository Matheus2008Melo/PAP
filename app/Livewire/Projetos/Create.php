<?php

namespace App\Livewire\Projetos;

use Livewire\Component;
use App\Livewire\Forms\ProjetoForm;
use App\Models\Disciplina;
use App\Models\Tag;

class Create extends Component
{
    public $index = '/projetos';
    public $modo = 'novo';
    public ProjetoForm $form;

    public function save()
    {
        if ($this->modo == 'novo') {
            $this->form->store();
        } else {
            $this->form->update();
        }
        
        return $this->redirect($this->index, navigate: true);
    }

    public function render()
    {
        return view('livewire.projetos.create', [
            'disciplinas' => Disciplina::where('is_active', true)->get(),
            'tags' => Tag::all(),
        ]);
    }
}