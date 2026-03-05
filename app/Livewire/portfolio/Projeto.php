<?php

namespace App\Livewire\Portfolio;

use Livewire\Component;
use App\Models\Projeto as ProjetoModel;
use App\Models\Comment;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;

class Projeto extends Component
{
    public ProjetoModel $projeto;
    public $comment = '';
    public $replyTo = null;

    protected $rules = [
        'comment' => 'required|min:3|max:1000',
    ];

    public function mount($projeto)
    {
        $this->projeto = ProjetoModel::where('slug', $projeto)
            ->where('status', 'aprovado')
            ->with(['disciplina', 'user', 'tags', 'comments.user', 'comments.replies.user'])
            ->firstOrFail();

        // Incrementar visitas
        $this->projeto->increment('visitas');
    }

    public function vote($type)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $existingVote = Vote::where('user_id', Auth::id())
            ->where('voteable_type', ProjetoModel::class)
            ->where('voteable_id', $this->projeto->id)
            ->first();

        if ($existingVote) {
            if ($existingVote->type === $type) {
                // Se clicar no mesmo voto, remove
                $existingVote->delete();
                $this->updateVoteCounts(-1, $type);
            } else {
                // Se mudar o voto, atualiza
                $oldType = $existingVote->type;
                $existingVote->update(['type' => $type]);
                $this->updateVoteCounts(0, $type);
                $this->updateVoteCounts(-1, $oldType);
            }
        } else {
            // Novo voto
            Vote::create([
                'user_id' => Auth::id(),
                'voteable_type' => ProjetoModel::class,
                'voteable_id' => $this->projeto->id,
                'type' => $type,
            ]);
            $this->updateVoteCounts(1, $type);
        }

        $this->projeto->refresh();
    }

    private function updateVoteCounts($change, $type)
    {
        if ($type === 'upvote') {
            $this->projeto->increment('upvotes', $change);
            $this->projeto->increment('vote_score', $change);
        } else {
            $this->projeto->increment('downvotes', $change);
            $this->projeto->decrement('vote_score', $change);
        }
    }

    public function addComment()
    {
        $this->validate();

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'project_id' => $this->projeto->id,
            'parent_id' => $this->replyTo,
            'comment' => $this->comment,
        ]);

        $this->comment = '';
        $this->replyTo = null;
        $this->projeto->refresh();

        session()->flash('comment_success', 'Comentário adicionado com sucesso!');
    }

    public function setReply($commentId)
    {
        $this->replyTo = $commentId;
        $this->dispatch('focus-comment-input');
    }

    public function voteComment($commentId, $type)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $comment = Comment::find($commentId);
        
        $existingVote = Vote::where('user_id', Auth::id())
            ->where('voteable_type', Comment::class)
            ->where('voteable_id', $commentId)
            ->first();

        if ($existingVote) {
            if ($existingVote->type === $type) {
                $existingVote->delete();
                $this->updateCommentVoteCounts($comment, -1, $type);
            } else {
                $oldType = $existingVote->type;
                $existingVote->update(['type' => $type]);
                $this->updateCommentVoteCounts($comment, 0, $type);
                $this->updateCommentVoteCounts($comment, -1, $oldType);
            }
        } else {
            Vote::create([
                'user_id' => Auth::id(),
                'voteable_type' => Comment::class,
                'voteable_id' => $commentId,
                'type' => $type,
            ]);
            $this->updateCommentVoteCounts($comment, 1, $type);
        }

        $this->projeto->refresh();
    }

    private function updateCommentVoteCounts($comment, $change, $type)
    {
        if ($type === 'upvote') {
            $comment->increment('upvotes', $change);
            $comment->increment('vote_score', $change);
        } else {
            $comment->increment('downvotes', $change);
            $comment->decrement('vote_score', $change);
        }
    }

    public function render()
    {
        return view('livewire.portfolio.projeto');
    }
}