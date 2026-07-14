<?php

namespace Database\Seeders;

use App\Models\Izin;
use App\Models\Lembur;
use App\Models\Presensi;
use App\Models\User;
use App\Support\Roles;
use App\Support\RoleSync;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoOperationalDataSeeder extends Seeder
{
    private const TIMEZONE = 'Asia/Jakarta';

    public function run(): void
    {
        $employees = collect([
            User::where('email', 'employee@example.com')->firstOrFail(),
            $this->upsertFieldEmployee(),
        ]);

        $this->upsertInactiveEmployee();

        foreach ($employees as $index => $employee) {
            $attendanceDates = $this->seedAttendance($employee, $index);
            $this->seedOvertime($employee, $attendanceDates);
            $this->seedLeave($employee, $index);
        }
    }

    private function upsertFieldEmployee(): User
    {
        $user = User::updateOrCreate(
            ['email' => 'field.staff@example.com'],
            [
                'nik' => 'DEMO-004',
                'nama' => 'Jordan Davis',
                'username' => 'field.staff',
                'password' => Hash::make('password'),
                'alamat' => 'Demo Address 4',
                'telepon' => '000-000-0004',
                'posisi' => 'Operational Staff',
                'tanggal_lahir' => '1997-03-19',
                'tanggal_masuk' => '2024-04-15',
                'gaji' => 225000,
                'tipe_gaji' => 'harian',
                'status' => 'aktif',
                'role' => Roles::KARYAWAN,
            ],
        );

        RoleSync::sync($user, Roles::KARYAWAN);

        return $user;
    }

    private function upsertInactiveEmployee(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'inactive.employee@example.com'],
            [
                'nik' => 'DEMO-005',
                'nama' => 'Casey Wilson',
                'username' => 'inactive.employee',
                'password' => Hash::make('password'),
                'alamat' => 'Demo Address 5',
                'telepon' => '000-000-0005',
                'posisi' => 'Former Employee',
                'tanggal_lahir' => '1994-11-07',
                'tanggal_masuk' => '2023-09-04',
                'gaji' => 5000000,
                'tipe_gaji' => 'bulanan',
                'status' => 'tidak aktif',
                'role' => Roles::KARYAWAN,
            ],
        );

        RoleSync::sync($user, Roles::KARYAWAN);
    }

    /**
     * @return array<int, CarbonImmutable>
     */
    private function seedAttendance(User $employee, int $employeeIndex): array
    {
        $today = CarbonImmutable::now(self::TIMEZONE)->startOfDay();
        $cursor = $today->startOfMonth();
        $lastDate = $today->subDay();
        $attendanceDates = [];
        $patterns = [
            ['07:55:00', '16:05:00'],
            ['08:10:00', '16:20:00'],
            ['08:35:00', '17:00:00'],
            ['08:00:00', '16:00:00'],
        ];

        while ($cursor->lessThanOrEqualTo($lastDate) && count($attendanceDates) < 14) {
            if ($cursor->isWeekday()) {
                $pattern = $patterns[(count($attendanceDates) + $employeeIndex) % count($patterns)];
                $date = $cursor->toDateString();

                Presensi::updateOrCreate(
                    [
                        'user_id' => $employee->user_id,
                        'tanggal' => $date,
                    ],
                    [
                        'jam_masuk' => "{$date} {$pattern[0]}",
                        'lokasi_masuk' => 'Demo Office',
                        'jam_keluar' => "{$date} {$pattern[1]}",
                        'lokasi_keluar' => 'Demo Office',
                        'lat_masuk' => 0.0000000,
                        'lng_masuk' => 0.0000000,
                        'accuracy_masuk' => 15,
                        'ip_masuk' => '127.0.0.1',
                        'ua_masuk' => 'DemoSeeder/1.0',
                        'lat_keluar' => 0.0000000,
                        'lng_keluar' => 0.0000000,
                        'accuracy_keluar' => 15,
                        'ip_keluar' => '127.0.0.1',
                        'ua_keluar' => 'DemoSeeder/1.0',
                    ],
                );

                $attendanceDates[] = $cursor;
            }

            $cursor = $cursor->addDay();
        }

        return $attendanceDates;
    }

    /**
     * @param  array<int, CarbonImmutable>  $attendanceDates
     */
    private function seedOvertime(User $employee, array $attendanceDates): void
    {
        foreach (array_slice($attendanceDates, -3) as $index => $date) {
            $dateString = $date->toDateString();
            $startHour = 17 + $index;
            $endHour = $startHour + 2;

            Lembur::updateOrCreate(
                [
                    'user_id' => $employee->user_id,
                    'tanggal' => $dateString,
                ],
                [
                    'jam_mulai_lembur' => sprintf('%s %02d:00:00', $dateString, $startHour),
                    'lokasi_mulai_lembur' => 'Demo Office',
                    'lat_mulai_lembur' => 0.0000000,
                    'lng_mulai_lembur' => 0.0000000,
                    'accuracy_mulai_lembur' => 15,
                    'ip_mulai_lembur' => '127.0.0.1',
                    'ua_mulai_lembur' => 'DemoSeeder/1.0',
                    'jam_pulang_lembur' => sprintf('%s %02d:00:00', $dateString, $endHour),
                    'lokasi_pulang_lembur' => 'Demo Office',
                    'lat_selesai_lembur' => 0.0000000,
                    'lng_selesai_lembur' => 0.0000000,
                    'accuracy_selesai_lembur' => 15,
                    'ip_selesai_lembur' => '127.0.0.1',
                    'ua_selesai_lembur' => 'DemoSeeder/1.0',
                ],
            );
        }
    }

    private function seedLeave(User $employee, int $employeeIndex): void
    {
        $leaveDate = CarbonImmutable::now(self::TIMEZONE)
            ->addDays(7 + $employeeIndex)
            ->nextWeekday();

        Izin::updateOrCreate(
            [
                'user_id' => $employee->user_id,
                'tanggal_izin' => $leaveDate->toDateString(),
            ],
            [
                'tanggal_pengajuan' => CarbonImmutable::now(self::TIMEZONE)->subDays(2),
                'keterangan' => $employeeIndex === 0
                    ? 'Fictional personal leave for portfolio demonstration.'
                    : 'Fictional appointment for portfolio demonstration.',
            ],
        );
    }
}
