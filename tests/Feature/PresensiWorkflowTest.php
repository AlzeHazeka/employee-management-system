<?php

namespace Tests\Feature;

use App\Models\Presensi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PresensiWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_check_in_and_check_out_use_authenticated_user_and_server_time(): void
    {
        Carbon::setTestNow(Carbon::create(2026, 7, 14, 8, 0, 0, 'Asia/Jakarta'));
        $user = User::factory()->create();
        $this->actingAs($user);

        $payload = ['latitude' => -6.2, 'longitude' => 106.8166667, 'accuracy' => 12];

        $this->postJson(route('presensi.masuk'), $payload)
            ->assertOk()
            ->assertJsonPath('status', 'success');

        $this->postJson(route('presensi.masuk'), $payload)
            ->assertOk()
            ->assertJsonPath('status', 'error');

        Carbon::setTestNow(Carbon::create(2026, 7, 14, 17, 0, 0, 'Asia/Jakarta'));

        $this->postJson(route('presensi.keluar'), $payload)
            ->assertOk()
            ->assertJsonPath('status', 'success');

        $presensi = Presensi::where('user_id', $user->user_id)->sole();
        $this->assertSame('2026-07-14 08:00:00', $presensi->getRawOriginal('jam_masuk'));
        $this->assertSame('2026-07-14 17:00:00', $presensi->getRawOriginal('jam_keluar'));
        $this->assertDatabaseCount('presensi', 1);
    }

    public function test_check_out_without_check_in_is_rejected(): void
    {
        Carbon::setTestNow(Carbon::create(2026, 7, 14, 17, 0, 0, 'Asia/Jakarta'));

        $this->actingAs(User::factory()->create())
            ->postJson(route('presensi.keluar'), [])
            ->assertOk()
            ->assertJsonPath('status', 'error');

        $this->assertDatabaseCount('presensi', 0);
    }

    public function test_invalid_coordinates_are_rejected(): void
    {
        Carbon::setTestNow(Carbon::create(2026, 7, 14, 8, 0, 0, 'Asia/Jakarta'));

        $this->actingAs(User::factory()->create())
            ->postJson(route('presensi.masuk'), ['latitude' => 91, 'longitude' => 181])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['latitude', 'longitude']);

        $this->assertDatabaseCount('presensi', 0);
    }

    public function test_user_cannot_check_out_another_users_attendance(): void
    {
        Carbon::setTestNow(Carbon::create(2026, 7, 14, 8, 0, 0, 'Asia/Jakarta'));
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $this->actingAs($owner)->postJson(route('presensi.masuk'))->assertOk();

        Carbon::setTestNow(Carbon::create(2026, 7, 14, 17, 0, 0, 'Asia/Jakarta'));

        $this->actingAs($otherUser)
            ->postJson(route('presensi.keluar'))
            ->assertOk()
            ->assertJsonPath('status', 'error');

        $this->assertNull(Presensi::where('user_id', $owner->user_id)->sole()->getRawOriginal('jam_keluar'));
    }
}
