<?php
 
namespace App\Livewire\Forms;
 
use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Comentario;
use Illuminate\Support\Facades\Auth;
 
class ComentarioForm extends Form
{
    public ?Comentario $comentario;
 
    #[Validate('required|integer')]
    public $post_id = '';
 
    #[Validate('nullable|integer')]
    public $parent_id = null;
 
    #[Validate('required|min:3')]
    public $conteudo = '';
 
    public function store()
    {
        $this->validate();
 
        Comentario::create([
            'user_id' => Auth::id(), // utilizador autenticado
            'post_id' => $this->post_id,
            'parent_id' => $this->parent_id,
            'conteudo' => $this->conteudo,
        ]);
 
        $this->reset('conteudo'); // limpa o campo depois de enviar
    }
 
    public function setComentario(Comentario $comentario)
    {
        $this->comentario = $comentario;
        $this->conteudo = $comentario->conteudo;
        $this->post_id = $comentario->post_id;
        $this->parent_id = $comentario->parent_id;
    }
 
    public function update()
    {
        $this->validate();
 
        $this->comentario->update([
            'conteudo' => $this->conteudo,
        ]);
    }
}