<?php

namespace Database\Seeders;

use App\Models\AttendanceLog;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $department = Department::create([
            'name' => 'Operations',
            'code' => 'OPS',
            'branch' => 'Riyadh Main',
        ]);

        $user = User::factory()->create([
            'name' => 'Ahmed Al-Saud',
            'email' => 'test@aura.local',
            'password' => bcrypt('password'),
        ]);

        $employee = Employee::create([
            'user_id' => $user->id,
            'department_id' => $department->id,
            'employee_number' => 'EMP001',
            'job_title' => 'Operations Specialist',
            'hire_date' => '2024-01-15',
            'branch' => 'Riyadh Main',
            'is_active' => true,
        ]);

        // Seed a check-in for today at 08:45 AM (on time)
        AttendanceLog::create([
            'employee_id' => $employee->id,
            'recorded_at' => Carbon::today()->setTime(8, 45),
            'type' => 'check_in',
            'source' => 'manual',
            'branch' => 'Riyadh Main',
            'raw_payload' => null,
        ]);
    }
}
