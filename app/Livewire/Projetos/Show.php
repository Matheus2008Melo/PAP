<?php

namespace App\Livewire\Projetos;

use App\Models\Projeto;

class Show extends Edit
{
    public function mount(Projeto $projeto = null)
    {
        parent::mount($projeto);
        $this->modo = 'ver';
    }
}