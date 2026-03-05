<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Partilhar disciplinas com todas as views de forma dinâmica
        View::composer('*', function ($view) {
            // Evita consultas repetidas na mesma requisição
            if (!View::shared('disciplinas')) {
                $disciplinas = collect([]);
                
                try {
                    // Verifica se a tabela existe antes de consultar (para evitar erros em migrações)
                    if (\Illuminate\Support\Facades\Schema::hasTable('disciplinas')) {
                        $disciplinas = \App\Models\Disciplina::query()
                            ->orderBy('ordem')
                            ->orderBy('nome')
                            ->get();
                    }
                } catch (\Exception $e) {
                    // Em caso de erro (ex: BD em baixo), mantém coleção vazia
                }
                
                $view->with('disciplinas', $disciplinas);
            }
        });
    }
}