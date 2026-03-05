<?php

namespace App\Livewire\Categorias;
use App\Models\Categoria;

class Show extends Edit
{
    public function mount(Categoria $categoria=null)
    {
        @parent::mount($categoria);
        $this->modo = 'ver';
    }
    

}

