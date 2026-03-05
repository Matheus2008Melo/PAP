<?php

namespace App\Livewire\Comentarios;

use Livewire\Component;
use App\Models\Comentario;

class Index extends Component
{
    public function render()
    {
        return view('livewire.comentarios.index', [
            'comentarios' => Comentario::all(),
        ]);
    }
}
