<?php

use App\Livewire\Chat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use \App\Models\User;
use \App\Models\Message;
use \Illuminate\Support\Facades\Auth;
Route::view('/', 'welcome');

Route::get('dashboard', function() {
    $authUserId = Auth::id();
    $users = User::where('id', '!=', $authUserId)->get();

    foreach ($users as $user) {
        $latestMessage = Message::where(function($query) use ($authUserId, $user) {
            $query->where('from_user_id', $authUserId)
                ->where('to_user_id', $user->id);
        })
            ->orWhere(function($query) use ($authUserId, $user) {
                $query->where('from_user_id', $user->id)
                    ->where('to_user_id', $authUserId);
            })
            ->latest('created_at')
            ->first();

        if ($latestMessage) {
            $createdAt = Carbon::parse($latestMessage->created_at);
            if ($createdAt->isToday()) {
                $latestMessage->formatted_date = $createdAt->format('H:i');
            } elseif ($createdAt->isYesterday()) {
                $latestMessage->formatted_date = 'Kemarin ' . $createdAt->format('H:i');
            } else {
                $latestMessage->formatted_date = $createdAt->format('Y-m-d');
            }
        }

        $user->latestMessage = $latestMessage;
    }

    return view('dashboard', [
        'users' => $users
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::get('/chat/{user}', Chat::class)->name('chat');

require __DIR__.'/auth.php';
