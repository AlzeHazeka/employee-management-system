<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Features;
use Tests\TestCase;

class ApiTokenPermissionsTest extends TestCase
{
    public function test_api_token_permission_updates_are_unavailable_when_api_support_is_disabled(): void
    {
        $this->assertFalse(Features::hasApiFeatures());
        $this->assertFalse(Route::has('api-tokens.update'));
    }
}
