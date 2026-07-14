<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TwoFactorAuthenticationSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_two_factor_authentication_can_be_enabled(): void
    {
        $this->actingAs($user = User::factory()->create());

        $this->withSession(['auth.password_confirmed_at' => time()]);

        $response = $this->from('/user/profile')->post(route('two-factor.enable', absolute: false));

        $response->assertStatus(302);

        $user = $user->fresh();

        $this->assertNotNull($user->two_factor_secret);
        $this->assertCount(8, $user->recoveryCodes());
    }

    public function test_recovery_codes_can_be_regenerated(): void
    {
        $this->actingAs($user = User::factory()->create());

        $this->withSession(['auth.password_confirmed_at' => time()]);

        $this->from('/user/profile')->post(route('two-factor.enable', absolute: false));

        $user = $user->fresh();

        $this->from('/user/profile')->post(route('two-factor.recovery-codes', absolute: false));

        $this->assertCount(8, $user->recoveryCodes());
        $this->assertCount(8, array_diff($user->recoveryCodes(), $user->fresh()->recoveryCodes()));
    }

    public function test_two_factor_authentication_can_be_disabled(): void
    {
        $this->actingAs($user = User::factory()->create());

        $this->withSession(['auth.password_confirmed_at' => time()]);

        $this->from('/user/profile')->post(route('two-factor.enable', absolute: false));

        $this->assertNotNull($user->fresh()->two_factor_secret);

        $this->from('/user/profile')->delete(route('two-factor.disable', absolute: false));

        $this->assertNull($user->fresh()->two_factor_secret);
    }
}
