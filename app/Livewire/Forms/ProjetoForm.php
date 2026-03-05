<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Projeto;
use App\Models\Disciplina;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjetoForm extends Form
{
    public ?Projeto $projeto = null;
    
    public $titulo = '';
    public $disciplina_id = '';
    public $descricao = '';
    public $descricao_curta = '';
    public $ano_letivo = '';
    public $url_externa = '';
    public $tags = [];
    public $status = 'pendente';
    public $is_featured = false;

    public function rules()
    {
        return [
            'titulo' => ['required', 'string', 'min:5', 'max:255'],
            'disciplina_id' => ['required', 'exists:disciplinas,id'],
            'descricao' => ['required', 'string', 'min:10'],
            'descricao_curta' => ['nullable', 'string', 'max:300'],
            'ano_letivo' => ['required', 'string'],
            'url_externa' => ['nullable', 'url'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id'],
            'status' => ['required', Rule::in(['rascunho', 'pendente', 'aprovado', 'rejeitado'])],
            'is_featured' => ['boolean'],
        ];
    }

    public function setProjeto(Projeto $projeto)
    {
        $this->projeto = $projeto;
        $this->titulo = $projeto->titulo;
        $this->disciplina_id = $projeto->disciplina_id;
        $this->descricao = $projeto->descricao;
        $this->descricao_curta = $projeto->descricao_curta;
        $this->ano_letivo = $projeto->ano_letivo;
        $this->url_externa = $projeto->url_externa;
        $this->tags = $projeto->tags->pluck('id')->toArray();
        $this->status = $projeto->status;
        $this->is_featured = $projeto->is_featured;
    }

    public function store()
    {
        $this->validate();

        $projeto = Projeto::create([
            'titulo' => $this->titulo,
            'slug' => Str::slug($this->titulo),
            'disciplina_id' => $this->disciplina_id,
            'descricao' => $this->descricao,
            'descricao_curta' => $this->descricao_curta,
            'ano_letivo' => $this->ano_letivo,
            'url_externa' => $this->url_externa,
            'status' => $this->status,
            'is_featured' => $this->is_featured,
            'user_id' => auth()->id(),
        ]);

        $projeto->tags()->sync($this->tags);

        session()->flash('success', 'Projeto criado com sucesso!');
    }

    public function update()
    {
        $this->validate();

        $this->projeto->update([
            'titulo' => $this->titulo,
            'slug' => Str::slug($this->titulo),
            'disciplina_id' => $this->disciplina_id,
            'descricao' => $this->descricao,
            'descricao_curta' => $this->descricao_curta,
            'ano_letivo' => $this->ano_letivo,
            'url_externa' => $this->url_externa,
            'status' => $this->status,
            'is_featured' => $this->is_featured,
        ]);

        $this->projeto->tags()->sync($this->tags);

        session()->flash('success', 'Projeto atualizado com sucesso!');
    }
}