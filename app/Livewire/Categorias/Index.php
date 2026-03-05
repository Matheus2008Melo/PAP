<?php

namespace App\Livewire\Categorias;

use Livewire\Component;
use App\Models\Categoria;

class Index extends Component
{
    public function render()
    {
        return view('livewire.categorias.index', [
            'categorias' => Categoria::all(),
        ]);
    }
}
