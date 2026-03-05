<?php

namespace App\Livewire\Disciplinas;

use App\Models\Disciplina;

class Edit extends Create
{
    public function mount(Disciplina $disciplina = null)
    {
        $this->form->setDisciplina($disciplina);
        $this->modo = 'editar';
    }
}