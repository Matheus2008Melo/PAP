<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Categoria    ;

class CategoriaForm extends Form
{
    
    public ?Categoria $categoria;
    #[Validate('required')]
    public $nome = '';
 
    #[Validate('required')]
    public $estado = '';

     public function store() 
    {
        $this->validate();
 
        Categoria::create($this->only(['nome', 'estado']));
    }

     public function update()
    {
        $this->validate();
 
        $this->categoria->update(
            $this->only(['nome', 'estado'])
        );
    }

    public function setCategoria(Categoria $categoria)
    {
        $this->categoria = $categoria;
 
        $this->nome = $categoria->nome;
 
        $this->estado = $categoria->estado;
    }


}
