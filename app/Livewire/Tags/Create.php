<?php

namespace App\Livewire\Tags;

use Livewire\Component;
use App\Livewire\Forms\TagForm;

class Create extends Component
{
    public $index = '/tags';
    public $modo = 'novo';
    public TagForm $form;

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
        return view('livewire.tags.create');
    }
}