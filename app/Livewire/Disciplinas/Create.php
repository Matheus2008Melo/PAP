<?php

namespace App\Livewire\Disciplinas;

use Livewire\Component;
use App\Livewire\Forms\DisciplinaForm;

class Create extends Component
{
    public $index = '/disciplinas';
    public $modo = 'novo';
    public DisciplinaForm $form;

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
        return view('livewire.disciplinas.create');
    }
}