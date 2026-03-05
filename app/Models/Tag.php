<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'tipo',
        'cor'
    ];

    public function projetos(): BelongsToMany
    {
        return $this->belongsToMany(Projeto::class, 'project_tag');
    }
}