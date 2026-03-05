<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjetoAnexo extends Model
{
    protected $fillable = [
        'projeto_id',
        'caminho_ficheiro',
        'nome_original',
        'extensao',
        'tamanho',
    ];

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }
}
