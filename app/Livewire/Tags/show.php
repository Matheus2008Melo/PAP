<?php

namespace App\Livewire\Tags;

use App\Models\Tag;

class Show extends Edit
{
    public function mount(Tag $tag = null)
    {
        parent::mount($tag);
        $this->modo = 'ver';
    }
}