<?php

namespace App\Livewire\Categorias;
use App\Models\Categoria;

class Edit extends Create
{
    public function mount(Categoria $categoria=null)
    {
        $this->form->setCategoria($categoria);
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

