<?php

namespace App\Livewire\Disciplinas;

use App\Models\Disciplina;

class Show extends Edit
{
    public function mount(Disciplina $disciplina = null)
    {
        parent::mount($disciplina);
        $this->modo = 'ver';
    }
}