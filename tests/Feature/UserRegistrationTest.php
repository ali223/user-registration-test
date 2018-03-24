<?php

namespace Tests\Feature;

use App\Mail\ActivationEmail;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function when_a_user_enters_a_new_email_they_are_registered_and_sent_an_activation_email()
    {
        Mail::fake();

        $this->post('/login', [
            'email' => 'johndoe@example.com',
            'password' => 'secret'
        ])->assertRedirect('/dashboard');

        $this->assertDatabaseHas('users', [
            'email' => 'johndoe@example.com'
        ]);

        Mail::assertQueued(ActivationEmail::class);
    }

    /** @test */
    public function when_a_user_enters_an_existing_email_with_valid_password_they_are_logged_in()
    {
        $user = factory(User::class)->create([            
            'email' => 'johndoe@example.com',
            'password' => bcrypt('secret')
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret'
        ])->assertRedirect('/dashboard');

        $this->get('/dashboard')
            ->assertSee($user->email);
    }

    /** @test */

    public function registered_users_can_activate_their_account()
    {
        Mail::fake();

        $this->post('/login', [
            'email' => 'johndoe@example.com',
            'password' => 'secret'
        ])->assertRedirect('/dashboard');

        $this->assertDatabaseHas('users', [
            'email' => 'johndoe@example.com'
        ]);

        $user = User::where('email', 'johndoe@example.com')->first();

        $this->assertFalse($user->active);        
        $this->assertNotNull($user->activation_token);

        $this->get('/activate?token=' . $user->activation_token);

        $this->assertTrue($user->fresh()->active);
        $this->assertNull($user->fresh()->activation_token);
    }
}
