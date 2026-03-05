<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Projeto;
use App\Models\Comment;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class ProjectInteractions extends Component
{
    public Projeto $projeto;
    public string $newComment = '';
    public float $selectedRating = 0.0;
    public bool $hasUserRated = false;

    public function mount(Projeto $projeto)
    {
        $this->projeto = $projeto;
        
        if (Auth::check()) {
            $userRating = Rating::where('user_id', Auth::id())
                ->where('projeto_id', $this->projeto->id)
                ->value('rating');
            
            if ($userRating) {
                $this->selectedRating = (float) $userRating;
                $this->hasUserRated = true;
            }
        }
    }

    public function rate()
    {
        $value = $this->selectedRating;
        \Illuminate\Support\Facades\Log::info('ProjectInteractions rate() called via $selectedRating with value: ' . $value);

        if (!Auth::check() || $this->hasUserRated) {
            \Illuminate\Support\Facades\Log::warning('rate() aborted: User not authenticated or already rated in state.');
            return;
        }

        $user = Auth::user();

        // Extra verificação por segurança
        $existingRating = Rating::where('user_id', $user->id)
                                ->where('projeto_id', $this->projeto->id)
                                ->first();
        
        if ($existingRating) {
            \Illuminate\Support\Facades\Log::warning('rate() aborted: Found existing rating in DB for user.');
            $this->hasUserRated = true;
            $this->selectedRating = (float) $existingRating->rating;
            return;
        }

        $value = (float) $value;
        if (!in_array($value, [0.5, 1.0, 1.5, 2.0, 2.5, 3.0, 3.5, 4.0, 4.5, 5.0])) {
            \Illuminate\Support\Facades\Log::warning('rate() aborted: Invalid rating value: ' . $value);
            return;
        }

        Rating::create([
            'user_id' => $user->id,
            'projeto_id' => $this->projeto->id,
            'rating' => $value
        ]);
        
        $this->hasUserRated = true;

        // Atualiza modelo e propriedades relativas a votos
        $this->refreshScores();
        \Illuminate\Support\Facades\Log::info('rate() successful, average updated.');
    }

    private function refreshScores()
    {
        $ratings = Rating::where('projeto_id', $this->projeto->id);
        
        $count = $ratings->count();
        $average = $count > 0 ? (float) $ratings->avg('rating') : 0;

        $this->projeto->update([
            'rating_count' => $count,
            'rating_average' => number_format($average, 1, '.', '')
        ]);

        // Refresh the loaded model instance to reflect new counts
        $this->projeto->refresh();
    }

    public function addComment()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate([
            'newComment' => 'required|min:2|max:1000'
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'project_id' => $this->projeto->id,
            'comment' => $this->newComment,
            'is_approved' => true // Default to true unless moderation is needed
        ]);

        $this->newComment = '';
        $this->projeto->load('comments.user');
        
        session()->flash('comment_message', 'Comentário adicionado com sucesso!');
    }

    public function render()
    {
        $userRating = null;
        if (Auth::check()) {
            $userRating = Rating::where('user_id', Auth::id())
                ->where('projeto_id', $this->projeto->id)
                ->value('rating');
        }

        return view('livewire.project-interactions', [
            'userRating' => $userRating,
            'comments' => $this->projeto->comments()->with('user')->orderBy('created_at', 'desc')->get()
        ]);
    }
}
