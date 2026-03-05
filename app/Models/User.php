<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'curso',
        'ano_escolar',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function projetos(): HasMany
    {
        return $this->hasMany(Projeto::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function sentConversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'sender_id');
    }

    public function receivedConversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'receiver_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function isModerator(): bool
    {
        return $this->isAdmin() || $this->isTeacher();
    }

    // ⭐⭐⭐ MÉTODOS ADICIONADOS ⭐⭐⭐
    
    /**
     * Obter todos os projetos aprovados do utilizador
     */
    public function projetosAprovados(): HasMany
    {
        return $this->projetos()->where('status', 'aprovado');
    }

    /**
     * Obter projetos pendentes do utilizador
     */
    public function projetosPendentes(): HasMany
    {
        return $this->projetos()->where('status', 'pendente');
    }

    /**
     * Obter projetos em destaque do utilizador
     */
    public function projetosDestaque(): HasMany
    {
        return $this->projetos()->where('is_featured', true);
    }

    /**
     * Verificar se o utilizador tem um projeto específico
     */
    public function possuiProjeto($projetoId): bool
    {
        return $this->projetos()->where('id', $projetoId)->exists();
    }

    /**
     * Contar o número total de projetos do utilizador
     */
    public function contarProjetos(): int
    {
        return $this->projetos()->count();
    }

    /**
     * Contar o número de comentários do utilizador
     */
    public function contarComentarios(): int
    {
        return $this->comments()->count();
    }

    /**
     * Obter a pontuação total do utilizador (soma dos vote_score dos projetos)
     */
    public function pontuacaoTotal(): int
    {
        return $this->projetos()->sum('vote_score');
    }

    /**
     * Verificar se o utilizador pode editar um projeto
     */
    public function podeEditarProjeto(Projeto $projeto): bool
    {
        return $this->isAdmin() || $this->id === $projeto->user_id;
    }

    /**
     * Verificar se o utilizador pode eliminar um projeto
     */
    public function podeEliminarProjeto(Projeto $projeto): bool
    {
        return $this->isAdmin() || $this->id === $projeto->user_id;
    }

    /**
     * Verificar se o utilizador pode moderar comentários
     */
    public function podeModerarComentarios(): bool
    {
        return $this->isAdmin() || $this->isTeacher();
    }

    /**
     * Obter avatar URL ou default
     */
    public function avatarUrl(): string
    {
        if ($this->avatar) {
            return \Storage::url($this->avatar);
        }
        
        // Avatar default baseado nas iniciais
        $initials = strtoupper(substr($this->name, 0, 2));
        $colors = ['bg-blue-500', 'bg-green-500', 'bg-purple-500', 'bg-red-500', 'bg-yellow-500'];
        $color = $colors[array_rand($colors)];
        
        return "https://ui-avatars.com/api/?name={$initials}&background=" . substr($color, 3) . "&color=fff&size=128";
    }

    /**
     * Obter o nome formatado (com role se for admin/teacher)
     */
    public function nomeFormatado(): string
    {
        if ($this->isAdmin()) {
            return "👑 {$this->name}";
        }
        
        if ($this->isTeacher()) {
            return "📚 {$this->name}";
        }
        
        return $this->name;
    }

    /**
     * Scope para obter apenas utilizadores ativos
     */
    public function scopeAtivos($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para obter utilizadores por role
     */
    public function scopePorRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope para obter utilizadores com projetos
     */
    public function scopeComProjetos($query)
    {
        return $query->has('projetos');
    }

    /**
     * Obter estatísticas do utilizador
     */
    public function estatisticas(): array
    {
        return [
            'projetos_total' => $this->contarProjetos(),
            'projetos_aprovados' => $this->projetosAprovados()->count(),
            'projetos_pendentes' => $this->projetosPendentes()->count(),
            'comentarios_total' => $this->contarComentarios(),
            'pontuacao_total' => $this->pontuacaoTotal(),
            'projetos_destaque' => $this->projetosDestaque()->count(),
        ];
    }
}