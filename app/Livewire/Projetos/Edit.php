<?php

namespace App\Livewire\Projetos;

use App\Models\Projeto;

class Edit extends Create
{
    public function mount(Projeto $projeto = null)
    {
        $this->form->setProjeto($projeto);
        $this->modo = 'editar';
    }
}