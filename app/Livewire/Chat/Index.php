<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $selectedConversationId = null;
    public $body = '';
    
    // Listeners for polling or external events if needed
    // However, wire:poll on the frontend will trigger re-renders automatically
    
    public function mount($userId = null)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($userId) {
            // Check if conversation exists
            $authId = Auth::id();
            
            // Cannot chat with yourself
            if ($authId == $userId) {
                return;
            }

            $conversation = Conversation::where(function ($query) use ($authId, $userId) {
                $query->where('sender_id', $authId)->where('receiver_id', $userId);
            })->orWhere(function ($query) use ($authId, $userId) {
                $query->where('sender_id', $userId)->where('receiver_id', $authId);
            })->first();

            if (!$conversation) {
                // Create a new conversation
                $conversation = Conversation::create([
                    'sender_id' => $authId,
                    'receiver_id' => $userId
                ]);
            }

            $this->selectConversation($conversation->id);
        }
    }

    public function selectConversation($conversationId)
    {
        $this->selectedConversationId = $conversationId;
        
        // Mark unread messages from the other user as read
        Message::where('conversation_id', $this->selectedConversationId)
            ->where('user_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function sendMessage()
    {
        $this->validate([
            'body' => 'required|string|max:2000'
        ]);

        if (!$this->selectedConversationId) {
            return;
        }

        Message::create([
            'conversation_id' => $this->selectedConversationId,
            'user_id' => Auth::id(),
            'body' => $this->body
        ]);

        $this->body = '';
    }

    public function getConversationsProperty()
    {
        $authId = Auth::id();
        return Conversation::with(['sender', 'receiver', 'messages' => function($query) {
                $query->latest()->limit(1);
            }])
            ->withCount(['messages as unread_count' => function ($query) use ($authId) {
                $query->where('user_id', '!=', $authId)->whereNull('read_at');
            }])
            ->where('sender_id', $authId)
            ->orWhere('receiver_id', $authId)
            ->get()
            ->sortByDesc(function ($conversation) {
                return $conversation->messages->first() ? $conversation->messages->first()->created_at : $conversation->created_at;
            });
    }

    public function render()
    {
        $activeConv = null;
        if ($this->selectedConversationId) {
            $activeConv = Conversation::with(['messages' => function($q) {
                $q->orderBy('created_at', 'asc')->with('user');
            }, 'sender', 'receiver'])->find($this->selectedConversationId);
        }

        return view('livewire.chat.index', [
            'conversations' => $this->conversations,
            'activeConversation' => $activeConv
        ])->layout('layouts.app');
    }
}
