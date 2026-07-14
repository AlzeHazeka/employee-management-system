<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_protected_dashboard(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_employee_cannot_access_admin_reporting_or_payroll(): void
    {
        $this->actingAs(User::factory()->create());

        $this->getJson(route('admin.presensi.by-date'))->assertForbidden();
        $this->getJson(route('payroll.daily.index'))->assertForbidden();
    }

    public function test_admin_can_access_reporting_and_payroll(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->get(route('admin.presensi.by-date'))->assertOk();
        $this->get(route('payroll.daily.index'))->assertOk();
    }

    public function test_employee_cannot_access_other_employee_records(): void
    {
        $employee = User::factory()->create();
        $otherEmployee = User::factory()->create();

        $this->actingAs($employee)
            ->getJson(route('data-user.show', $otherEmployee->user_id))
            ->assertForbidden();
    }
}
