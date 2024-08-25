<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Message;

class Chat extends Component
{
    public User $user;

    public $message = '';
    public $messages = [];

   public function mount()
   {
        $this->loadMessages();
        $this->markMessagesAsRead();
   }
   public function hydrate()
   {
       $this->loadMessages();
       $this->markMessagesAsRead();
   }
   protected function loadMessages()
   {
       $this->messages = Message::where(function ($query) {
           $query->where('from_user_id', auth()->id())
               ->orWhere('to_user_id', $this->user->id);
       })
           ->orWhere(function($query) {
               $query->where('from_user_id', $this->user->id)
                   ->where('to_user_id', auth()->id());
           })->get();
   }

    protected function markMessagesAsRead()
    {
        $updatedRows = Message::where('to_user_id', auth()->id())
            ->where('from_user_id', $this->user->id)
            ->where('status', 'sent')
            ->update(['status' => 'read']);

        $toUserId = auth()->id();
        $fromUserId = $this->user->id;

        \Log::info("Updated {$updatedRows} messages to 'read' status.");
        \Log::info("to user id {$toUserId}");
        \Log::info("from user id {$fromUserId}");

//        ('from user id ', 2)
    }

    public function sendMessage()
    {
        $message = Message::create([
            'from_user_id' => auth()->id(),
            'to_user_id' => $this->user->id,
            'message' => $this->message,
            'status' => 'pending', // Initial status
        ]);

        // Simulate status update after sending
        $message->update(['status' => 'sent']);

        $this->reset('message');
    }

    public function render()
    {
        return view('livewire.chat', [
            'messages' => $this->messages,
        ]);
    }

}
