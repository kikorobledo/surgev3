<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{

    use RefreshDatabase;

    public function test_can_see_livewire_component_on_profile_page(): void
    {

        $user = User::factory()->create();

        $this->actingAs($user)
            /* ->withoutExceptionHandling() */
            ->get('/profile')
            ->assertSuccessful()
            ->assertSeeLivewire('profile');
    }

    public function test_can_update_profile(): void
    {

        $user = User::factory()->create();

        Livewire::actingAs($user)
                    ->test('profile')
                    ->set('name', 'foo')
                    ->set('birthday', '08/03/2023')
                    ->set('about', 'bar')
                    ->call('save');

        $user->refresh();

        $this->assertEquals('foo', $user->name);
        $this->assertEquals('bar', $user->about);

    }

    public function test_name_must_less_than_24_characters(): void
    {

        $user = User::factory()->create();

        Livewire::actingAs($user)
                    ->test('profile')
                    ->set('name', str_repeat('a', 25))
                    ->set('about', str_repeat('a', 141))
                    ->call('save')
                    ->assertHasErrors(['name' => 'max']);

    }

    public function test_about_must_less_than_24_characters(): void
    {

        $user = User::factory()->create();

        Livewire::actingAs($user)
                    ->test('profile')
                    ->set('name', str_repeat('a', 25))
                    ->set('about', str_repeat('a', 141))
                    ->call('save')
                    ->assertHasErrors(['about' => 'max']);

    }

    public function test_profile_info_is_prepopulated(): void
    {

        $user = User::factory()->create([
            'name' => 'foo',
            'about' => 'bar'
        ]);

        Livewire::actingAs($user)
                    ->test('profile')
                    ->assertSet('name', 'foo')
                    ->assertSet('about', 'bar');

    }

    public function test_message_is_shown_at_save(): void
    {

        $user = User::factory()->create([
            'name' => 'foo',
            'about' => 'bar'
        ]);

        Livewire::actingAs($user)
                    ->test('profile')
                    ->set('name', 'foo')
                    ->set('birthday', '08/03/2023')
                    ->set('about', 'bar')
                    ->call('save')
                    ->assertDispatched('notify-saved');

    }

    public function test_can_upload_avatar(): void
    {

        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('photo.png');

        Storage::fake('avatars');

        Livewire::actingAs($user)
                    ->test('profile')
                    ->set('name', 'foo')
                    ->set('birthday', '08/03/2023')
                    ->set('about', 'bar')
                    ->set('newAvatar', $file)
                    ->call('save');

        $user->refresh();

        $this->assertNotNull($user->avatar);

        Storage::disk('avatars')->assertExists($user->avatar);

    }

}
