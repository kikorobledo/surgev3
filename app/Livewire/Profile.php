<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

class Profile extends Component
{

    use WithFileUploads;

    public $saved = false;
    #[Rule('required|max:24')]
    public $name = '';
    #[Rule('required|max:140')]
    public $about = '';
    #[Rule('date|sometimes')]
    public $birthday;
    #[Rule('nullable|image|max:1000')]
    public $newAvatar;

    public function save(){

        $this->validate();

        if($this->newAvatar)
            $fileName = $this->newAvatar->store('/', 'avatars');
        else
            $fileName = null;

        auth()->user()->update([
            'name' => $this->name,
            'birthday' => $this->birthday,
            'about' => $this->about,
            'avatar' => $fileName,
        ]);

        $this->saved = true;

        /* $this->dispatch('notify', 'Profile save!'); */

        $this->dispatch('notify-saved');

    }

    public function updated($field){

        if($field !== 'saved'){

            $this->saved = false;

        }

    }

    public function mount(){

        $this->name = auth()->user()->name;
        $this->about = auth()->user()->about;
        $this->birthday = optional(auth()->user()->birthday)->format('m/d/Y');

    }

    #[Layout('components.layouts.base')]
    #[Title('Login')]
    public function render()
    {
        return view('livewire.profile');
    }
}
