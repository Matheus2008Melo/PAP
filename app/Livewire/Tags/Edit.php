<?php

namespace App\Livewire\Tags;

use App\Models\Tag;

class Edit extends Create
{
    public function mount(Tag $tag = null)
    {
        $this->form->setTag($tag);
        $this->modo = 'editar';
    }
}