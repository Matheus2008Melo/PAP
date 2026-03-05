<?php

namespace App\Livewire\Comentarios;

use Livewire\Component;
use App\Livewire\Forms\ComentarioForm;

class Create extends Component
{
    public $index = '/comentarios';
    public $modo = 'novo';
    public ComentarioForm $form;
 
    public function save()
    {
        if ($this->modo=='novo')    
            $this->form->store(); 
        else 
            $this->form->update(); 
 
        return $this->redirect($this->index);
    }

    public function render()
    {
        return view('livewire.comentarios.create');
    }
}
