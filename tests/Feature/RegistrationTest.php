<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\Features;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_is_disabled_for_portfolio(): void
    {
        $this->assertFalse(Features::enabled(Features::registration()));
    }

    public function test_registration_screen_cannot_be_rendered_if_support_is_disabled(): void
    {
        $this->get('/register')->assertNotFound();
    }

    public function test_public_registration_submission_is_rejected(): void
    {
        $response = $this->post('/register', [
            'nama' => 'Demo User',
            'username' => 'demo-user',
            'email' => 'demo.user@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertNotFound();
        $this->assertGuest();
        $this->assertDatabaseCount('users', 0);
    }
}
