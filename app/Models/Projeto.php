<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Projeto extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'disciplina_id',
        'titulo',
        'slug',
        'descricao',
        'descricao_curta',
        'ano_letivo',
        'url_externa',
        'metadados',
        'status',
        'featured_image',
        'ficheiro',
        'ficheiro_nome',
        'visitas',
        'rating_average',
        'rating_count',
        'is_featured',
        'published_at'
    ];

    protected $casts = [
        'metadados' => 'array',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function disciplina(): BelongsTo
    {
        return $this->belongsTo(Disciplina::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'project_tag');
    }

    public function disciplinasSecundarias(): BelongsToMany
    {
        return $this->belongsToMany(Disciplina::class, 'disciplina_projeto');
    }

    public function anexos(): HasMany
    {
        return $this->hasMany(ProjetoAnexo::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'project_id');
    }

    public function media(): MorphMany
    {
        return $this->morphMany(\App\Models\Media::class, 'model');
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    // Helper methods for In-Browser Viewer
    public function getFileExtension(): string
    {
        return strtolower(pathinfo($this->ficheiro_nome, PATHINFO_EXTENSION));
    }

    public function getFileTypeCategory(): string
    {
        $ext = $this->getFileExtension();
        
        if ($ext === 'pdf') {
            return 'pdf';
        }
        
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'])) {
            return 'image';
        }
        
        if (in_array($ext, ['zip', 'rar', '7z', 'tar', 'gz', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'])) {
            return 'archive_document';
        }
        
        // Assume anything else might be text/code (php, html, css, js, py, txt, etc.)
        return 'code';
    }
}