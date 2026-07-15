<?php

namespace Database\Factories;

use App\Models\AttendanceLog;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AttendanceLog>
 */
class AttendanceLogFactory extends Factory
{
    protected $model = AttendanceLog::class;

    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'recorded_at' => $this->faker->dateTimeBetween('-8 hours', 'now'),
            'type' => $this->faker->randomElement(['check_in', 'check_out']),
            'source' => $this->faker->randomElement(['biometric', 'manual']),
            'branch' => $this->faker->city(),
            'raw_payload' => null,
        ];
    }
}
