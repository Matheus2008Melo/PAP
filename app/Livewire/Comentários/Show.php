<?php

namespace App\Livewire\Comentarios;
use App\Models\Comentario;

class Show extends Edit
{
    public function mount(Comentario $comentario=null)
    {
        @parent::mount($comentario);
        $this->modo = 'ver';
    }
    

}

