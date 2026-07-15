<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'department_id' => Department::factory(),
            'employee_number' => $this->faker->unique()->numerify('EMP###'),
            'job_title' => $this->faker->jobTitle(),
            'hire_date' => $this->faker->date(),
            'branch' => $this->faker->city(),
            'is_active' => true,
        ];
    }
}
