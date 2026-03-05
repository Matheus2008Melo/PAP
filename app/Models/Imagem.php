<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagem extends Model
{
    use HasFactory;
    protected $table = 'imagens';

    protected $fillable = [
        'post_id',
        'url',
        'is_cover',
        'legenda',
    ];

    protected $casts = [
        'is_cover' => 'boolean',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
