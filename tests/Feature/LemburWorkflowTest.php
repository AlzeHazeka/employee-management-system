<?php

namespace Tests\Feature;

use App\Models\Lembur;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LemburWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_overtime_start_and_finish_are_scoped_to_authenticated_user(): void
    {
        Carbon::setTestNow(Carbon::create(2026, 7, 14, 18, 0, 0, 'Asia/Jakarta'));
        $user = User::factory()->create();
        $this->actingAs($user);

        $payload = ['latitude' => -6.2, 'longitude' => 106.8166667, 'accuracy' => 15];

        $this->postJson(route('lembur.mulai'), $payload)
            ->assertOk()
            ->assertJsonPath('status', 'success');

        $this->postJson(route('lembur.mulai'), $payload)
            ->assertOk()
            ->assertJsonPath('status', 'error');

        Carbon::setTestNow(Carbon::create(2026, 7, 14, 21, 0, 0, 'Asia/Jakarta'));

        $this->postJson(route('lembur.pulang'), $payload)
            ->assertOk()
            ->assertJsonPath('status', 'success');

        $lembur = Lembur::where('user_id', $user->user_id)->sole();
        $this->assertSame('2026-07-14 18:00:00', $lembur->getRawOriginal('jam_mulai_lembur'));
        $this->assertSame('2026-07-14 21:00:00', $lembur->getRawOriginal('jam_pulang_lembur'));
        $this->assertDatabaseCount('lembur', 1);
    }

    public function test_overtime_finish_without_start_is_rejected(): void
    {
        Carbon::setTestNow(Carbon::create(2026, 7, 14, 21, 0, 0, 'Asia/Jakarta'));

        $this->actingAs(User::factory()->create())
            ->postJson(route('lembur.pulang'))
            ->assertOk()
            ->assertJsonPath('status', 'error');

        $this->assertDatabaseCount('lembur', 0);
    }

    public function test_invalid_overtime_coordinates_are_rejected(): void
    {
        Carbon::setTestNow(Carbon::create(2026, 7, 14, 18, 0, 0, 'Asia/Jakarta'));

        $this->actingAs(User::factory()->create())
            ->postJson(route('lembur.mulai'), ['latitude' => -91, 'longitude' => -181])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['latitude', 'longitude']);

        $this->assertDatabaseCount('lembur', 0);
    }
}
