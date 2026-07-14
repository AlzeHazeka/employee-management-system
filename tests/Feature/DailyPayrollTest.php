<?php

namespace Tests\Feature;

use App\Models\Lembur;
use App\Models\Presensi;
use App\Models\User;
use App\Services\Payroll\DailyPayrollService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DailyPayrollTest extends TestCase
{
    use RefreshDatabase;

    public function test_daily_payroll_calculation_is_deterministic(): void
    {
        $employee = User::factory()->create(['gaji' => 100000, 'tipe_gaji' => 'harian']);

        Presensi::create([
            'user_id' => $employee->user_id,
            'tanggal' => '2026-07-13',
            'jam_masuk' => '2026-07-13 08:00:00',
            'jam_keluar' => '2026-07-13 16:00:00',
        ]);
        Presensi::create([
            'user_id' => $employee->user_id,
            'tanggal' => '2026-07-14',
            'jam_masuk' => '2026-07-14 08:00:00',
            'jam_keluar' => '2026-07-14 16:00:00',
        ]);
        Lembur::create([
            'user_id' => $employee->user_id,
            'tanggal' => '2026-07-14',
            'jam_mulai_lembur' => '2026-07-14 17:00:00',
            'jam_pulang_lembur' => '2026-07-14 22:00:00',
        ]);

        $result = app(DailyPayrollService::class)->calculateDailyPayroll(
            $employee,
            '2026-07-13',
            '2026-07-14',
            100000,
        );

        $this->assertSame(16, $result['payroll']['attendance_payable_hours']);
        $this->assertSame(5, $result['payroll']['overtime_payable_hours']);
        $this->assertSame(200000.0, $result['payroll']['attendance_gross_total']);
        $this->assertSame(112500.0, $result['payroll']['overtime_total']);
        $this->assertSame(312500.0, $result['payroll']['gross_total']);
    }

    public function test_employee_cannot_call_payroll_calculation_endpoint(): void
    {
        $employee = User::factory()->create(['gaji' => 100000, 'tipe_gaji' => 'harian']);

        $this->actingAs($employee)
            ->postJson(route('payroll.daily.calculate'), [
                'karyawan_id' => $employee->user_id,
                'tanggal_mulai' => '2026-07-13',
                'tanggal_selesai' => '2026-07-14',
                'mode' => 'calculate',
                'gaji_per_hari' => 100000,
            ])
            ->assertForbidden();
    }
}
