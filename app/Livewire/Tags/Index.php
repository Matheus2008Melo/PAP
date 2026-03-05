<?php

namespace App\Livewire\Tags;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tag;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $tipoFilter = '';

    public function delete(Tag $tag)
    {
        $tag->delete();
        session()->flash('success', 'Tag eliminada com sucesso!');
    }

    public function render()
    {
        $tags = Tag::when($this->search, function ($query) {
                $query->where('nome', 'like', '%' . $this->search . '%');
            })
            ->when($this->tipoFilter, function ($query) {
                $query->where('tipo', $this->tipoFilter);
            })
            ->orderBy('tipo')
            ->orderBy('nome')
            ->paginate(10);

        return view('livewire.tags.index', [
            'tags' => $tags,
        ]);
    }
}