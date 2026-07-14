<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    public function test_email_verification_is_disabled_for_portfolio(): void
    {
        $this->assertFalse(Features::enabled(Features::emailVerification()));
    }

    public function test_email_verification_routes_are_not_registered(): void
    {
        $this->assertFalse(Route::has('verification.notice'));
        $this->assertFalse(Route::has('verification.verify'));
        $this->assertFalse(Route::has('verification.send'));
    }

    public function test_email_verification_endpoints_return_not_found(): void
    {
        $this->get('/email/verify')->assertNotFound();
        $this->post('/email/verification-notification')->assertNotFound();
    }
}
