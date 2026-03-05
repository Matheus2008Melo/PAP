<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\DB; // Added for DB facade

// Rota principal - página estática enquanto não tens o Livewire configurado

Route::get('/', function () {
    $destaques = \App\Models\Projeto::where('status', 'aprovado')
        ->orderByDesc('rating_average')
        ->take(3)
        ->get();
        
    return view('home', compact('destaques'));
})->name('home');

// Rota para todas as disciplinas
Route::get('/disciplinas', function () {
    return view('disciplines-index');
})->name('disciplines.index');

// Rota para disciplinas
Route::get('/disciplina/{slug}', function ($slug) {
    $disciplina = \App\Models\Disciplina::where('slug', $slug)->firstOrFail();
    return view('discipline-show', ['disciplina' => $disciplina, 'slug' => $slug]);
})->name('discipline.show');

// Rota para projetos
Route::get('/disciplina/{disciplineSlug}/{projectSlug}', function ($disciplineSlug, $projectSlug) {
    $disciplina = \App\Models\Disciplina::where('slug', $disciplineSlug)->firstOrFail();
    $projeto = \App\Models\Projeto::where('slug', $projectSlug)
                                  ->where('disciplina_id', $disciplina->id)
                                  ->with(['user', 'tags'])
                                  ->firstOrFail();

    return view('project-show', [
        'disciplina' => $disciplina,
        'projeto' => $projeto
    ]);
})->name('project.show');

// Rota para download seguro de ficheiros do projeto
Route::get('/projeto/{projeto}/download', function (\App\Models\Projeto $projeto) {
    if (!$projeto->ficheiro) {
        abort(404);
    }
    return \Illuminate\Support\Facades\Storage::disk('public')->download($projeto->ficheiro, $projeto->ficheiro_nome);
})->name('project.download');

// Rota para visualização inline de ficheiros do projeto (iFrame/Previews)
Route::get('/projeto/{projeto}/preview', function (\App\Models\Projeto $projeto) {
    if (!$projeto->ficheiro) {
        abort(404);
    }
    $path = \Illuminate\Support\Facades\Storage::disk('public')->path($projeto->ficheiro);
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path);
})->name('project.preview');

// Rota para o Chat (Mensagens Diretas)
Route::get('/chat/{userId?}', \App\Livewire\Chat\Index::class)
    ->middleware(['auth'])
    ->name('chat');

// Rotas para download e preview da nova estrutura de Anexos Múltiplos
Route::get('/anexo/{anexo}/download', function (\App\Models\ProjetoAnexo $anexo) {
    return \Illuminate\Support\Facades\Storage::disk('public')->download($anexo->caminho_ficheiro, $anexo->nome_original);
})->name('anexo.download');

Route::get('/anexo/{anexo}/preview', function (\App\Models\ProjetoAnexo $anexo) {
    // Para renderizar o inline preview de um anexo
    $path = \Illuminate\Support\Facades\Storage::disk('public')->path($anexo->caminho_ficheiro);
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path);
})->name('anexo.preview');

// Rotas de autenticação (se tiveres Breeze/Laravel UI)
// Rotas Autenticadas
Route::middleware(['auth'])->group(function () {
    // Dashboard do Estudante / Professor (aponta para o mesmo componente por enquanto)
    Livewire\Volt\Volt::route('/dashboard', 'student.dashboard')->name('dashboard');
    Livewire\Volt\Volt::route('/meus-projetos', 'student.dashboard')->name('my-projects');

    // Placeholder para perfil (será implementado futuramente)
    Route::get('/profile', function () {
        return redirect()->route('dashboard');
    })->name('profile');
});

require __DIR__.'/auth.php';

// Rota para submeter projeto
Route::get('/submeter-projeto', function () {
    return view('submit-project');
})->name('submit-project')->middleware('auth');

// Rota para painel admin (protegida por middleware admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');

    // Apagar projeto (Apenas Admin)
    Route::delete('/projetos/{projeto}', function (\App\Models\Projeto $projeto) {
        $projeto->delete();
        return redirect()->route('home')->with('success', 'Projeto eliminado com sucesso.');
    })->name('project.destroy');
});