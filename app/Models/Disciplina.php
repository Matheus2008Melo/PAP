<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Disciplina extends Model
{
    use HasFactory;

    /**
     * Os atributos que são mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'slug',
        'abreviatura',
        'descricao',
        'cor',
        'icone',
        'is_active',
        'ordem',
        'metadata',
    ];

    /**
     * Os atributos que devem ser convertidos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot do modelo.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($disciplina) {
            if (empty($disciplina->slug)) {
                $disciplina->slug = Str::slug($disciplina->nome);
            }
        });

        static::updating(function ($disciplina) {
            if ($disciplina->isDirty('nome') && empty($disciplina->slug)) {
                $disciplina->slug = Str::slug($disciplina->nome);
            }
        });
    }

    /**
     * Obter o nome da tabela.
     */
    public function getTable()
    {
        return 'disciplinas';
    }

    /**
     * Relação com projetos.
     */
    public function projetos()
    {
        return $this->hasMany(Projeto::class, 'disciplina_id');
    }

    /**
     * Projetos ativos (aprovados).
     */
    public function projetosAtivos()
    {
        return $this->hasMany(Projeto::class, 'disciplina_id')
                    ->where('status', 'aprovado');
    }

    /**
     * Scope para disciplinas ativas.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para ordenação.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('ordem')->orderBy('nome');
    }

    /**
     * Acessor para contagem de projetos ativos.
     */
    public function getProjetosCountAttribute()
    {
        if ($this->relationLoaded('projetos')) {
            return $this->projetos->count();
        }
        
        return $this->projetos()->count();
    }

    /**
     * Acessor para contagem de projetos ativos.
     */
    public function getProjetosAtivosCountAttribute()
    {
        if ($this->relationLoaded('projetosAtivos')) {
            return $this->projetosAtivos->count();
        }
        
        return $this->projetosAtivos()->count();
    }

    /**
     * Obter o nome da rota.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * URL da disciplina.
     */
    public function getUrlAttribute()
    {
        return route('discipline.show', $this->slug);
    }
}