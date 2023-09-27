<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{

    use RefreshDatabase;

    public function test_registration_page_contains_livewire_component(){

        $this->get('/register')->assertSeeLivewire('auth.registration');

    }

    public function test_can_register(){

        Livewire::test('auth.registration')
                ->set('email', 'correo@correo.com')
                ->set('password', '12345678')
                ->set('password_confirmation', '12345678')
                ->set('name', 'kiko')
                ->call('register')
                ->assertRedirect('/');

        $this->assertTrue(User::where('email', 'correo@correo.com')->exists());

        $this->assertEquals('correo@correo.com', auth()->user()->email);

    }

    public function test_email_is_required(){

        Livewire::test('auth.registration')
                ->set('email', '')
                ->set('password', '12345678')
                ->set('password_confirmation', '12345678')
                ->set('name', 'kiko')
                ->call('register')
                ->assertHasErrors(['email' => 'required']);

    }

    public function test_email_is_valid_email(){

        Livewire::test('auth.registration')
                ->set('email', 'asdfs')
                ->set('password', '12345678')
                ->set('password_confirmation', '12345678')
                ->set('name', 'kiko')
                ->call('register')
                ->assertHasErrors(['email' => 'email']);

    }

    public function test_email_is_availablle(){

        User::create([
            'name' => 'kiko',
            'email' => 'correo@correo.com',
            'password' => '123465'
        ]);

        Livewire::test('auth.registration')
                ->set('email', 'correo@correo.com')
                ->set('password', '12345678')
                ->set('password_confirmation', '12345678')
                ->set('name', 'kiko')
                ->call('register')
                ->assertHasErrors(['email' => 'unique']);

    }

    public function test_password_is_required(){

        User::create([
            'name' => 'kiko',
            'email' => 'correo@correo.com',
            'password' => '123465'
        ]);

        Livewire::test('auth.registration')
                ->set('email', 'correo@correo.com')
                ->set('password', '')
                ->set('password_confirmation', '12345678')
                ->set('name', 'kiko')
                ->call('register')
                ->assertHasErrors(['password' => 'required']);

    }

    public function test_password_min_6(){

        User::create([
            'name' => 'kiko',
            'email' => 'correo@correo.com',
            'password' => '123465'
        ]);

        Livewire::test('auth.registration')
                ->set('email', 'correo@correo.com')
                ->set('password', '12345')
                ->set('password_confirmation', '12345')
                ->set('name', 'kiko')
                ->call('register')
                ->assertHasErrors(['password' => 'min:6']);

    }

    public function test_password_matches_password_confirmation(){

        User::create([
            'name' => 'kiko',
            'email' => 'correo@correo.com',
            'password' => '123465'
        ]);

        Livewire::test('auth.registration')
                ->set('email', 'correo@correo.com')
                ->set('password', '12345')
                ->set('password_confirmation', '1234578')
                ->set('name', 'kiko')
                ->call('register')
                ->assertHasErrors(['password' => 'same:password_confirmation']);

    }

    public function test_see_email_hasnt_allreade_taken_validation_message_as_user_types(){

        User::create([
            'name' => 'kiko',
            'email' => 'correo@correo.com',
            'password' => '123465'
        ]);

        Livewire::test('auth.registration')
                ->set('email', 'correo@correo.co')
                ->assertHasNoErrors()
                ->set('email', 'correo@correo.com')
                ->assertHasErrors(['email' => 'unique']);

    }

}
