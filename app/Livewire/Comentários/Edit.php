<?php

namespace App\Livewire\Comentarios;
use App\Models\Comentario;

class Edit extends Create
{
    public function mount(Comentario $comentario=null)
    {
        $this->form->setComentario($comentario);
        $this->modo = 'editar';
    }
    
    /*
    public function save() 
    {
        $this->form->update(); 
 
        return $this->redirect($this->index);
    }
    */

}

