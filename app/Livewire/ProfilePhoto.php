<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ProfilePhoto extends Component
{
    use WithFileUploads;

    public $photo;

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:2048',
        ]);
    }
    public function render()
    {
        return view('livewire.profile-photo');
    }

    public function savePhoto()
    {
        $this->validate([
            'photo' => 'image|max:2048',
        ]);

        $path = $this->photo->store('photo-profile','public');

        auth()->user()->update(['profile_photo_path' => $path]);

        session()->flash("success", "Your photo has been uploaded");
    }
}
