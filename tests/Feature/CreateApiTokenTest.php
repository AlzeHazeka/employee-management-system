<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Features;
use Tests\TestCase;

class CreateApiTokenTest extends TestCase
{
    public function test_api_tokens_cannot_be_created_when_api_support_is_disabled(): void
    {
        $this->assertFalse(Features::hasApiFeatures());
        $this->assertFalse(Route::has('api-tokens.store'));
    }
}
