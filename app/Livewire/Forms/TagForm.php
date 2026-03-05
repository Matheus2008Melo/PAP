<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Tag;
use Illuminate\Validation\Rule;

class TagForm extends Form
{
    public ?Tag $tag = null;
    
    public $nome = '';
    public $tipo = 'ano_escolar';
    public $cor = '#6B7280';

    public function rules()
    {
        return [
            'nome' => ['required', 'string', 'min:2', 'max:50'],
            'tipo' => ['required', Rule::in(['ano_escolar', 'tecnologia', 'tema'])],
            'cor' => ['required', 'string'],
        ];
    }

    public function setTag(Tag $tag)
    {
        $this->tag = $tag;
        $this->nome = $tag->nome;
        $this->tipo = $tag->tipo;
        $this->cor = $tag->cor;
    }

    public function store()
    {
        $this->validate();

        Tag::create([
            'nome' => $this->nome,
            'tipo' => $this->tipo,
            'cor' => $this->cor,
        ]);

        session()->flash('success', 'Tag criada com sucesso!');
    }

    public function update()
    {
        $this->validate();

        $this->tag->update([
            'nome' => $this->nome,
            'tipo' => $this->tipo,
            'cor' => $this->cor,
        ]);

        session()->flash('success', 'Tag atualizada com sucesso!');
    }
}   