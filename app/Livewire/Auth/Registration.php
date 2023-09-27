<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;

class Registration extends Component
{

    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    public function updatedEmail(){

        $this->validate([
            'email' => ['unique:users']
        ]);

    }

    public function register(){

        $this->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|same:password_confirmation|min:6'
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);

        auth()->login($user);

        return redirect('/');

    }

    #[Layout('components.layouts.app')]
    #[Title('Registration')]
    public function render()
    {
        return view('livewire.auth.registration');
    }
}
