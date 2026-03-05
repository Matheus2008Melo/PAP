<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Projeto;
use App\Models\Disciplina;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SubmitProject extends Component
{
    use WithFileUploads;

    public $titulo;
    public $disciplina_id; // Primary Discipline
    public $disciplinas_secundarias = []; // Secondary Disciplines
    public $descricao;
    public $ano_letivo;
    public $imagem;
    public $ficheiro;
    public $tags;

    protected $rules = [
        'titulo' => 'required|string|max:255',
        'disciplina_id' => 'required|exists:disciplinas,id',
        'disciplinas_secundarias' => 'nullable|array',
        'disciplinas_secundarias.*' => 'exists:disciplinas,id',
        'descricao' => 'required|string',
        'ano_letivo' => 'required|string',
        'imagem' => 'nullable|image|max:15360', // 15MB Max
        'ficheiro' => 'required|array', // Agora é um array obrigatório
        'ficheiro.*' => 'file|mimes:pdf,doc,docx,ppt,pptx,zip,rar,jpg,jpeg,png|max:153600', // Cada ficheiro máx 150MB
        'tags' => 'nullable|string',
    ];

    public function submit()
    {
        $this->validate();

        $slug = Str::slug($this->titulo) . '-' . Str::random(6);
        $imagePath = null;
        if ($this->imagem) {
            $imagePath = $this->imagem->store('projects', 'public');
        }

        $filePath = null;
        $fileName = null;

        // O $ficheiro agora é um array graças à validação 'array'
        if ($this->ficheiro && is_array($this->ficheiro) && count($this->ficheiro) > 0) {
            // Guardar o primeiro ficheiro na coluna principal para compatibilidade retroativa
            $firstFile = $this->ficheiro[0];
            $fileName = $firstFile->getClientOriginalName();
            $filePath = $firstFile->store('project_files', 'public');
        }

        $projeto = Projeto::create([
            'user_id' => Auth::id(),
            'disciplina_id' => $this->disciplina_id,
            'titulo' => $this->titulo,
            'slug' => $slug,
            'descricao' => $this->descricao,
            'ano_letivo' => $this->ano_letivo,
            'featured_image' => $imagePath,
            'ficheiro' => $filePath,
            'ficheiro_nome' => $fileName,
            'status' => 'pendente', // Default status waiting for approval
            'published_at' => now(),
        ]);

        // Guardar TODOS os múltiplos ficheiros na nova tabela projeto_anexos
        if ($this->ficheiro && is_array($this->ficheiro)) {
            foreach ($this->ficheiro as $file) {
                // store the file
                $anexoPath = $file->store('project_files', 'public');
                $anexoName = $file->getClientOriginalName();
                $anexoExt = $file->getClientOriginalExtension();
                $anexoSize = $file->getSize();

                \App\Models\ProjetoAnexo::create([
                    'projeto_id' => $projeto->id,
                    'caminho_ficheiro' => $anexoPath,
                    'nome_original' => $anexoName,
                    'extensao' => $anexoExt,
                    'tamanho' => $anexoSize,
                ]);
            }
        }

        // Associa as disciplinas secundárias (parcerias)
        if (!empty($this->disciplinas_secundarias)) {
            // Se por engano o aluno selecionou a disciplina principal na secundária, remove para não duplicar
            $secundariasLimpas = array_diff($this->disciplinas_secundarias, [$this->disciplina_id]);
            $projeto->disciplinasSecundarias()->attach($secundariasLimpas);
        }

        // Process tags if any (simple implementation)
        // You might need to implement tag logic here

        session()->flash('message', 'Projeto submetido com sucesso! Aguarda aprovação.');
        
        return redirect()->route('my-projects');
    }

    public function render()
    {
        return view('livewire.submit-project', [
            'disciplinas' => Disciplina::all()
        ]);
    }
}
