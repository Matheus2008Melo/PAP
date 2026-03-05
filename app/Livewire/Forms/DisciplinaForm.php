<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Disciplina;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DisciplinaForm extends Form
{
    public ?Disciplina $disciplina = null;
    
    public $nome = '';
    public $abreviatura = '';
    public $descricao = '';
    public $icone = 'fa-book';
    public $cor = '#3B82F6';
    public $ordem = 0;
    public $is_active = true;

    public function rules()
    {
        return [
            'nome' => ['required', 'string', 'min:3', 'max:100'],
            'abreviatura' => ['nullable', 'string', 'max:10'],
            'descricao' => ['nullable', 'string'],
            'icone' => ['required', 'string'],
            'cor' => ['required', 'string'],
            'ordem' => ['required', 'integer'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    public function setDisciplina(Disciplina $disciplina)
    {
        $this->disciplina = $disciplina;
        $this->nome = $disciplina->nome;
        $this->abreviatura = $disciplina->abreviatura;
        $this->descricao = $disciplina->descricao;
        $this->icone = $disciplina->icone;
        $this->cor = $disciplina->cor;
        $this->ordem = $disciplina->ordem;
        $this->is_active = $disciplina->is_active;
    }

    public function store()
    {
        $this->validate();

        Disciplina::create([
            'nome' => $this->nome,
            'slug' => Str::slug($this->nome),
            'abreviatura' => $this->abreviatura,
            'descricao' => $this->descricao,
            'icone' => $this->icone,
            'cor' => $this->cor,
            'ordem' => $this->ordem,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', 'Disciplina criada com sucesso!');
    }

    public function update()
    {
        $this->validate();

        $this->disciplina->update([
            'nome' => $this->nome,
            'slug' => Str::slug($this->nome),
            'abreviatura' => $this->abreviatura,
            'descricao' => $this->descricao,
            'icone' => $this->icone,
            'cor' => $this->cor,
            'ordem' => $this->ordem,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', 'Disciplina atualizada com sucesso!');
    }
}