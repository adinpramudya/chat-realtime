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
        $this->markMessagesAsRead();
    }

    public function hydrate()
    {
           $this->markMessagesAsRead();
    }

    protected function markMessagesAsRead()
    {
        foreach ($this->messages as $message) {
            if ($message->to_user_id == auth()->id() && $message->status == 'unread') {
                \Log::info("Marking message {$message->id} as read.");
                $this->markAsRead($message->id);
            }
        }
    }

public function markAsRead($messageId)
{
    $message = Message::find($messageId);
    if ($message && $message->to_user_id == auth()->id() && $message->status == 'unread') {
        \Log::info("Updating message {$messageId} status to 'read'.");
        $message->update(['status' => 'read']);
        \Log::info("Message {$messageId} status updated to: " . $message->status);
        $this->dispatchBrowserEvent('message-read', ['messageId' => $messageId]);
    } else {
        \Log::info("Message {$messageId} not updated, either not found or status is not 'unread'.");
    }
}
   public function render()
{
    $this->messages = Message::where('from_user_id', auth()->id())
        ->orWhere('from_user_id', $this->user->id)
        ->orWhere('to_user_id', auth()->id())
        ->orWhere('to_user_id', $this->user->id)
        ->get();
    \Log::info("Messages: " . count($this->messages));
    return view('livewire.chat', [
        'messages' => $this->messages,
    ]);
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


}
