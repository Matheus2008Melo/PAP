<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'categoria_id',
        'titulo',
        'slug',
        'conteudo',
        'published_at',
    ];

    protected $dates = [
        'published_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function imagens()
    {
        return $this->hasMany(Imagem::class, 'post_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'post_id');
    }
}
